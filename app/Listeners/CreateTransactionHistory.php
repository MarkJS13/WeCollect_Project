<?php

namespace App\Listeners;

use App\Events\TransactionMade;
use App\Models\Collector;
use App\Models\Consumer;
use App\Models\History;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateTransactionHistory implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionMade $event): void
    {
        $transaction = $event->transaction;

        $collector = Collector::findOrFail($transaction->collector_id);
        $supplier = Supplier::findOrFail($transaction->supplier_id);
        $customer = Consumer::findOrFail($transaction->consumer_id);
        $user = User::findOrFail($transaction->user_id);
    

        $overview = $user->name . ' created a transaction with ' . $supplier->name . ', ' . $customer->name . ', ' . $collector->name;

        History::create([
            'user_id' => $transaction->user_id,
            'history_overview' => $overview
        ]);
    }
}
