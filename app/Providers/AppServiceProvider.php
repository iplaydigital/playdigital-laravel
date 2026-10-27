<?php

namespace App\Providers;

use App\Models\Service;
use App\Models\WorkCategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            $host = request()->getHost();
            if (request()->isSecure() || str_ends_with($host, '.e2b.app')) {
                URL::forceScheme('https');
            }
        }

        View::composer('*', function ($view) {
            $shared = once(function (): array {
                $navCategories = collect();
                $serviceOptions = collect();

                try {
                    if (Schema::hasTable('work_categories')) {
                        $navCategories = WorkCategory::orderBy('sort_order')->get();
                    }
                    if (Schema::hasTable('services')) {
                        $serviceOptions = Service::orderBy('sort_order')->get();
                    }
                } catch (\Throwable) {
                    // Database not migrated yet during CLI bootstrap
                }

                return [
                    'siteConfig' => config('playdigital'),
                    'navCategories' => $navCategories,
                    'serviceOptions' => $serviceOptions,
                ];
            });

            foreach ($shared as $key => $value) {
                $view->with($key, $value);
            }
        });
    }
}
