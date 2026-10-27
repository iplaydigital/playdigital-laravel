<?php

namespace App\Http\Controllers;

use App\Models\AboutRule;
use App\Models\Service;
use App\Models\Work;
use App\Models\WorkCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        if ($request->filled('page')) {
            return $this->handleLegacyQuery($request);
        }

        return $this->renderHome();
    }

    public function handleLegacyQuery(Request $request): View|RedirectResponse
    {
        $page = strtolower((string) $request->query('page', 'home'));

        return match ($page) {
            'work' => redirect()->route('work.index'),
            'clients', 'client' => redirect()->route('clients.index'),
            'category' => $this->redirectLegacyCategory($request),
            'detail-work', 'detail-workvdo', 'detail-vdo' => $this->redirectLegacyWork($request),
            'blog' => redirect()->route('blog.index'),
            'contact' => redirect()->route('contact.index'),
            default => $this->renderHome(),
        };
    }

    protected function redirectLegacyCategory(Request $request): RedirectResponse
    {
        if (! $request->filled('cid')) {
            return redirect()->route('work.index');
        }

        $cid = $request->query('cid');
        $cat = is_numeric($cid)
            ? WorkCategory::where('legacy_cid', (int) $cid)->first()
            : null;

        return redirect()->route('work.category', [
            'category' => $cat ? $cat->slug : $cid,
        ]);
    }

    protected function redirectLegacyWork(Request $request): RedirectResponse
    {
        if (! $request->filled('id')) {
            return redirect()->route('work.index');
        }

        $id = $request->query('id');
        $work = is_numeric($id)
            ? Work::where('legacy_id', (int) $id)->first()
            : null;

        return redirect()->route('work.show', [
            'work' => $work ? $work->slug : $id,
        ]);
    }

    protected function renderHome(): View
    {
        return view('pages.home', [
            'featuredWorks' => Work::with('category')->where('is_featured_home', true)->orderBy('sort_order')->get(),
            'aboutRules' => AboutRule::orderBy('sort_order')->get(),
            'services' => Service::orderBy('sort_order')->get(),
        ]);
    }
}
