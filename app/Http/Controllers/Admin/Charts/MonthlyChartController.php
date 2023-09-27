<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\Supplier;
use App\Models\Transaction;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Carbon\Carbon;

/**
 * Class DashboardChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */

class MonthlyChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();

        // MANDATORY. Set the labels for the dataset points (supplier names)
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December',
        ];
        $this->chart->labels($months);

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/monthly-chart'));

        // OPTIONAL
        // $this->chart->minimalist(false);
         $this->chart->displayLegend(false);
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    public function data()
    {
        $currentYear = Carbon::now()->year;
        $transactionCounts = [];

    
        for ($month = 1; $month <= 12; $month++) {
            $transactionsCount = Transaction::whereYear('transaction_date', $currentYear)
                ->whereMonth('transaction_date', $month)
                ->count();
            $transactionCounts[] = $transactionsCount;
        }


        $this->chart->dataset('Monthly Transactions', 'line', $transactionCounts)->color('green')
            ->backgroundColor('rgba(205, 32, 31, 0.4)');
    }
}


