<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\WorkCategory;
use Illuminate\View\View;

class WorkController extends Controller
{
    public function index(): View
    {
        $categories = WorkCategory::orderBy('sort_order')->get();
        $works = Work::with('category')->orderBy('sort_order')->get();

        return view('pages.work.index', [
            'categories' => $categories,
            'activeCategory' => null,
            'works' => $works,
        ]);
    }

    public function category(string $category): View
    {
        $categories = WorkCategory::orderBy('sort_order')->get();

        $activeCategory = is_numeric($category)
            ? WorkCategory::where('legacy_cid', (int) $category)->firstOrFail()
            : WorkCategory::where('slug', $category)->firstOrFail();

        $works = Work::with('category')
            ->where('work_category_id', $activeCategory->id)
            ->orderBy('sort_order')
            ->get();

        return view('pages.work.index', [
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'works' => $works,
        ]);
    }

    public function show(string $work): View
    {
        $query = Work::with('category');

        $item = is_numeric($work)
            ? $query->where('legacy_id', (int) $work)->orWhere('id', (int) $work)->firstOrFail()
            : $query->where('slug', $work)->firstOrFail();

        $relatedWorks = Work::with('category')
            ->where('work_category_id', $item->work_category_id)
            ->where('id', '!=', $item->id)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('pages.work.show', [
            'work' => $item,
            'relatedWorks' => $relatedWorks,
        ]);
    }
}
