<?php

namespace App\Providers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('manage-category', function (User $user, Category $category) {
            return $category->user_id == $user->id;
        });

        Gate::define('manage-transaction', function (User $user, Transaction $transaction) {
            return $transaction->user_id == $user->id;
        });

        Gate::define('manage-budget', function (User $user, Budget $budget) {
            return $budget->user_id == $user->id;
        });
    }
}
