<?php

namespace App\Http\Requests;

use App\Models\Collector;
use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'transaction_date' => 'required',
            'consumer_id' => 'required',
            'collector_id' => 'required',
            'supplier_id' => 'required',
            'status' => 'required',
            'amount' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $collectorId = $this->input('collector_id');
                    $collector = Collector::find($collectorId);
    
                    if (!$collector) {
                        $fail('Selected collector is not valid.');
                        return;
                    }

                    $limits = [
                        1 => 5000,
                        2 => 10000,
                        3 => 15000,
                        4 => 1000000000000000
                    ];
    
                    // Check if the amount exceeds the collector's limit
                    if ($collector->collector_level > 0 && $value > $limits[$collector->collector_level]) {
                        $message = "Transaction amount exceeds the collector's limit for the selected level. Level {$collector->collector_level} collector can only transact {$limits[$collector->collector_level]} below";
                    $fail($message);
                    }
                },
            ],
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
