<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SubjectRequest as StoreRequest;
use App\Http\Requests\SubjectRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class SubjectCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SubjectCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Subject');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/subject');
        $this->crud->setEntityNameStrings('subject', 'subjects');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        $this->crud->removeColumn('admin_id');
        $this->crud->removeField('admin_id');

        // add asterisk for fields that are required in SubjectRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        $user_id = backpack_user()->id;
        $this->crud->addClause('where','admin_id','=',$user_id);
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $request->request->set('admin_id', backpack_user()->id);
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}