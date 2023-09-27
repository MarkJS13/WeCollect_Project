<?php

namespace App\Providers;

use App\Models\Collector;
use App\Models\Consumer;
use App\Models\Supplier;
use App\Models\Transaction;
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
        View::composer('*', function ($view) {
            $transactions_per_day_average = Transaction::selectRaw('DATE(transaction_date) as date, COUNT(*) as count')
                ->groupBy('date')
                ->pluck('count')
                ->average();

            $view->with('transactions_per_day_average', $transactions_per_day_average);
        });

        View::composer('*', function ($view) {
            $transaction_amount_total = Transaction::sum('amount');
            $view->with('transaction_amount_total', $transaction_amount_total);
        });

        View::composer('*', function ($view) {
            $total_suppliers = Supplier::all()->count();
            $view->with('total_suppliers', $total_suppliers);
        });

        View::composer('*', function ($view) {
            $total_consumers = Consumer::all()->count();
            $view->with('total_consumers', $total_consumers);
        });

        View::composer('*', function ($view) {
            $total_collectors = Collector::all()->count();
            $view->with('total_collectors', $total_collectors);
        });
    }
}
