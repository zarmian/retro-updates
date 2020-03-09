<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Models\Accounts\Tax;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaxController extends Controller
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

        $data['departments'] = Tax::paginate($data['per_page']);
        return view('accounting.tax.manage', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.tax.create');
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
            'code' => 'required',
            'rate' => 'required'
        ]);

        $title = $request->input('title');
        $code = $request->input('code');
        $rate = $request->input('rate');


        $department = new Tax;
        $department->name = $title;
        $department->code = $code;
        $department->rate = $rate;
        $department->type = '1';
        $result = $department->save();
        if($result){
            $request->session()->flash('msg', __('Tax has been create successfully.'));
        }
        return redirect('/accounting/tax/add');

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
    public function edit($id = NULL)
    {

        if(is_null($id)){ return redirect('accounting/tax'); }

        $data['department'] = Tax::find($id);
        return view('accounting.tax.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Admin\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = NULL)
    {
        
        if(is_null($id)){ return redirect('/accounting/tax'); }

        $this->validate($request, [
            'title' => 'required',
            'code' => 'required',
            'rate' => 'required',
        ]);

        $title = $request->input('title');
        $code = $request->input('code');
        $rate = $request->input('rate');

        $department = Tax::find($id);
        $department->name = $title;
        $department->code = $code;
        $department->rate = $rate;
        $result = $department->save();
        if($result){
            $request->session()->flash('msg', __('Tax has been updated successfully.'));
        }
        return redirect('/accounting/tax/edit/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Admin\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = NULL)
    {
        if(is_null($id)){ return redirect('/accounting/tax'); }

        $result = Tax::destroy($id);
        if($result){
            session()->flash('msg', __('Tax has been successfully removed.'));
        }

        return redirect('/accounting/tax');
    }
}
