<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Admin\EmployeesRoles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Admin\EmployeesPermissions;

class EmployeesRolesController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            
            $data['per_page'] = \Request::get('per_page');

            $data['roles'] = EmployeesRoles::paginate($data['per_page']);
            return view('admin.employees.roles.manage', $data);

        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            $data['permissions'] = EmployeesPermissions::get();
            return view('admin.employees.roles.create', $data);
        
        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            
            $this->validate($request, [
                'title' => 'required'
            ]);

            $title = $request->input('title');
            $description = $request->input('description');
            $permissions = serialize($request->input('permissions'));

            $role = new EmployeesRoles;
            $role->title = $title;
            $role->description = $description;
            $role->permissions = $permissions;

            $result = $role->save();

            if($result){
                $request->session()->flash('msg', __('admin/employees.role_updated'));
            }

            return redirect('/roles/create');


        } catch (ModelNotFoundException $e) {
            return redirect('/roles/');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Admin\EmployeesRoles  $employeesRoles
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeesRoles $employeesRoles, $id = NULL)
    {
        try {

            if(is_null($id)){ return redirect('/roles'); }

            $data['role'] = $employeesRoles->findOrFail($id);

            $data['allowed_permissions'] = unserialize($data['role']->permissions);
            $data['permissions'] = EmployeesPermissions::get();

            return view('admin.employees.roles.edit', $data);

        } catch (ModelNotFoundException $e) {
            return redirect('/roles');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Admin\EmployeesRoles  $employeesRoles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeesRoles $employeesRoles, $id = NULL)
    {
        try {

            if(is_null($id)){ return redirect('/employees/roles'); }

            $this->validate($request, [
                'title' => 'required'
            ]);

            $title = $request->input('title');
            $description = $request->input('description');
            $permissions = serialize($request->input('permissions'));

            $role = $employeesRoles->findOrFail($id);
            $role->title = $title;
            $role->description = $description;
            $role->permissions = $permissions;

            $result = $role->save();

            if($result){
                $request->session()->flash('msg', __('admin/employees.role_updated'));
            }

            return redirect('/roles/edit/'.$role->id);

        } catch (ModelNotFoundException $e) {
            return redirect('/roles');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Admin\EmployeesRoles  $employeesRoles
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeesRoles $employeesRoles, $id = NULL)
    {
        try {

             if(is_null($id)){ return redirect('/employees/roles'); }

             $role = $employeesRoles->where('default', '0')->findOrFail($id);
             $result = $employeesRoles->destroy($role->id);

             if($result){
                session()->flash('msg', __('admin/employees.role_delete'));
             }

             return redirect('/roles');
            
        } catch (ModelNotFoundException $e) {
            return redirect('/roles');
        }
    }
}
