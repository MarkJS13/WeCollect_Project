<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('collector', 'CollectorCrudController');
    Route::crud('supplier', 'SupplierCrudController');
    Route::crud('consumer', 'ConsumerCrudController');
    Route::crud('transaction', 'TransactionCrudController');
    Route::get('charts/monthly-chart', 'Charts\MonthlyChartController@response')->name('charts.monthly-chart.index');
    Route::get('charts/top-suppliers', 'Charts\TopSuppliersChartController@response')->name('charts.top-suppliers.index');
    Route::crud('history', 'HistoryCrudController');
}); // this should be the absolute last line of this file