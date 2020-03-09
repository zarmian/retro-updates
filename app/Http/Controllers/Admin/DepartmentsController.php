<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Admin\Departments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentsController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        $data = [];

        $data['per_page'] = \Request::get('per_page') ?: 12;

        $data['departments'] = Departments::paginate($data['per_page']);
        return view('admin.departments.manage', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'status' => 'required'
        ]);

        $title = $request->input('title');
        $description = $request->input('description');
        $status = $request->input('status');


        $department = new Departments;
        $department->title = $title;
        $department->description = $title;
        $department->status = $status;
        $result = $department->save();
        if($result){
            $request->session()->flash('msg', __('admin/departments.added'));
        }
        return redirect('/departments/create');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Admin\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function show(Departments $departments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Admin\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function edit(Departments $departments, $id = NULL)
    {

        if(is_null($id)){ return redirect('admin/departments'); }

        $data['department'] = $departments->find($id);
        return view('admin.departments.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Admin\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departments $departments, $id = NULL)
    {
        
        if(is_null($id)){ return redirect('/departments'); }

        $this->validate($request, [
            'title' => 'required',
            'status' => 'required'
        ]);

        $title = $request->input('title');
        $description = $request->input('description');
        $status = $request->input('status');

        $department = $departments->find($id);
        $department->title = $title;
        $department->description = $description;
        $department->status = $status;
        $result = $department->save();
        if($result){
            $request->session()->flash('msg', __('admin/departments.update'));
        }
        return redirect('/departments/edit/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Admin\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departments $departments, $id = NULL)
    {
        if(is_null($id)){ return redirect('admin/departments'); }

        $result = $departments->destroy($id);
        if($result){
            session()->flash('msg', __('admin/departments.remove'));
        }

        return redirect('/departments');
    }
}
