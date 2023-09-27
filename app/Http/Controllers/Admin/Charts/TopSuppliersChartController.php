<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\Supplier;
use App\Models\Transaction;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

/**
 * Class TopSuppliersChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TopSuppliersChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();

        // MANDATORY. Set the labels for the dataset points
        $suppliers = Supplier::pluck('name')->toArray();

        $this->chart->labels($suppliers);


        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/top-suppliers'));

        // OPTIONAL
        $this->chart->displayAxes(false);
        $this->chart->displayLegend(true);
        
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    public function data()
    {
        $suppliers = Supplier::all();
        $transactions_count = [];


        foreach ($suppliers as $supplier) {
            $transactionCount = Transaction::where('supplier_id', $supplier->id)->count();

            $transactions_count[] = $transactionCount;
        }
        

        $this->chart->dataset('Transactions by Supplier', 'pie', $transactions_count)->backgroundColor([
                'rgb(70, 127, 208)',
                'rgb(77, 189, 116)',
                'rgb(96, 92, 168)',
                'rgb(255, 193, 7)',
            ]);
    }
}