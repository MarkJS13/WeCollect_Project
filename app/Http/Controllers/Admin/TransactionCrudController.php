<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TransactionRequest;
use App\Models\Consumer;
use App\Models\Collector;
use App\Models\Supplier;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

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
        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
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

        $this->crud->field('transaction_date')->type('date');
        $this->crud->field('amount')->type('number');
        $this->crud->addField([
            'name' => 'supplier_id',
            'label' => 'Choose a supplier',
            'type' => 'select',
            'entity' => 'supplier', // The entity name for the CRUD controller
            'attribute' => 'name', // The attribute to display in the dropdown (supplier name)
            'model' => 'App\Models\Supplier', // The fully qualified namespace of the Supplier model
            'attributes' => ['id' => 'supplier_id'], // The attribute to store in the database (supplier ID)
        ]);

        $this->crud->addField([
            'name' => 'consumer_id',
            'label' => 'Choose a consumer',
            'type' => 'select',
            'entity' => 'consumer', 
            'attribute' => 'name',
            'model' => 'App\Models\Consumer',
            'attributes' => ['id' => 'consumer_id'], 
        ]);

        $this->crud->addField([
            'name' => 'collector_id',
            'label' => 'Choose a collector',
            'type' => 'select',
            'entity' => 'collector', 
            'attribute' => 'name', 
            'model' => 'App\Models\Collector', 
            'attributes' => ['id' => 'collector_id'], 
        ]);

        $this->crud->field([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select_from_array',
            'options' => ['' => '-', 'Completed' => 'Completed', 'Pending' => 'Pending', 'Failed' => 'Failed'],
        ]);

        // $this->crud->field([
        //     'name' => 'consumer_name',
        //     'label' => 'Choose a consumer',
        //     'type' => 'select_from_array',
        //     'options' => Consumer::getConsumerOptions(), 
        // ]);

        // $this->crud->field([
        //     'name' => 'collector_name',
        //     'label' => 'Choose a collector',
        //     'type' => 'select_from_array',
        //     'options' => Collector::getCollectorsOptions(), 
        // ]);        
        

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */


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
