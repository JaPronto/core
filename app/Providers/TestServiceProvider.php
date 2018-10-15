<?php

namespace App\Providers;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (app()->environment() === 'production') return;
        $this->paginationMacro()
        ->resourcePaginationMacro();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function paginationMacro()
    {
        TestResponse::macro('assertHasPagination', function () {
            $this->assertJsonStructure([
                'current_page',
                'data',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]);
        });

        return $this;
    }

    public function resourcePaginationMacro()
    {
        TestResponse::macro('assertPaginationResource', function () {
            $this->assertJsonStructure([
                'data',
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next'
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total'
                ]
            ]);
        });
    }
}
