<?php

namespace App\Http\Controllers\Admin;

use App\Events\TransactionMade;
use App\Http\Requests\TransactionRequest;
use App\Models\Supplier;
use App\Models\Transaction;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

/**
 * Class TransactionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TransactionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        $this->crud->setModel(\App\Models\Transaction::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/transaction');
        $this->crud->setEntityNameStrings('transaction', 'transactions');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->column('transaction_date')->type('date')->label('Transaction Date');
        $this->crud->column('supplier_id')->label('Supplier Name');
        $this->crud->column('consumer_id')->label('Customer Name');
        $this->crud->column('collector_id')->label('Collector Name');
        $this->crud->column('amount');
        $this->crud->column('status');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TransactionRequest::class);

        $this->crud->field('transaction_date')->type('date')->value(now());
        $this->crud->addField([
            'name' => 'consumer_id',
            'label' => 'Choose a consumer',
            'type' => 'select2',
            'entity' => 'consumer',
            'attribute' => 'name',
            'model' => 'App\Models\Consumer',
            'attributes' => ['id' => 'consumer_id'],
        ]);

        $this->crud->addField([
            'name' => 'supplier_id',
            'label' => 'Choose a supplier',
            'type' => 'select2_from_array', 
            'entity' => 'supplier',
            'options' => Supplier::getActiveSuppliers(), // options sa dropdown
            'model' => 'App\Models\Supplier',
            'attributes' => ['id' => 'supplier_id'],
        ]);

        
        $this->crud->addField([
            'name' => 'collector_id',
            'label' => 'Choose a collector',
            'type' => 'select2',
            'entity' => 'collector',
            'attribute' => 'name',
            'model' => 'App\Models\Collector',
            'attributes' => ['id' => 'collector_id'],
        ]);
        

        $this->crud->field('amount')->type('number')->min(0)->attributes(['min' => 0]);

        $this->crud->field([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select_from_array',
            'options' => ['' => '-', 'Completed' => 'Completed', 'Pending' => 'Pending', 'Failed' => 'Failed'],
        ]);

        
        $this->crud->addField([
            'name' => 'user_id',
            'label' => 'User ID', 
            'type' => 'hidden',
            'value' => backpack_auth()->user()->id,
        ]);

    }

    public function store(TransactionRequest $request)
    {
        $transaction = new Transaction(); 
        $transaction->fill($request->all());
        $transaction->save(); 

        
        event(new TransactionMade($transaction));

        return Redirect::to('/admin/transaction');
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    

}
