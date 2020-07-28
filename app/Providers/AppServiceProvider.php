<?php

namespace App\Providers;

use App\Services\Feed\FeedApiService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FeedApiService::class, function () {
            return new FeedApiService(config('services.product_feed'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->extendCollectionWithPaginate();
        Schema::defaultStringLength(191);
    }

    /**
     * Macro to extends Laravel Collection
     * If you have a collection called $item and you want to paginate it like Eloquent paginate:
     * $items->paginate($perPage)
     */
    private function extendCollectionWithPaginate()
    {
        if (!\Illuminate\Support\Collection::hasMacro('paginate')) {
            \Illuminate\Support\Collection::macro(
                'paginate',
                function ($perPage = 15, $page = null, $options = []) {
                    $options = empty($options) ? ['path' => request()->url()] : $options;
                    $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
                    return (new \Illuminate\Pagination\LengthAwarePaginator(
                        $this->forPage($page, $perPage),
                        $this->count(),
                        $perPage,
                        $page,
                        $options
                    ));
                }

            );
        }
    }
}
