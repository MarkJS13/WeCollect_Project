<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CollectorRequest;
use App\Models\Collector;
use App\Models\Transaction;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CollectorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CollectorCrudController extends CrudController
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
        $this->crud->setModel(\App\Models\Collector::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/collector');
        $this->crud->setEntityNameStrings('collector', 'collectors');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // set columns from db columns.

        //CRUD::column('id')->type('my_custom_column');
        $this->crud->column('images')->label('Image')->type('image');
        $this->crud->column('name');
        $this->crud->column('area')->prefix('Around ')->suffix(' Vicinity');
        $this->crud->column('collector_level');
        
        $this->crud->addColumn([
            'name' => 'bills',
            'label' => 'Cash on hand',
            'type' => 'model_function',
            'function_name' => 'getBillsAttribute',
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(CollectorRequest::class);
        //CRUD::setFromDb(); // set fields from db columns.

        $this->crud->field('images')->label('Image');
        $this->crud->field('name');
        $this->crud->field('area');
        $this->crud->field([
            'name' => 'collector_level',
            'label' => 'Collector Level',
            'type' => 'select_from_array',
            'options' => ['' => '-', 1 => '1', 2 => '2', 3 => '3', 4 => '4']
        ]);

        // $collector = new Collector();
        // $this->crud->addField([
        //     'name' => 'bills',
        //     'label' => 'Cash on hand',
        //     'type' => 'text', 
        //     'value' => $collector->getBillsAttribute(),
        //     'attributes' => ['readonly' => 'readonly'],
        // ]);

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
