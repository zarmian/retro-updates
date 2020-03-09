<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Database\Elqouent\ModelNotFoundException;
use App\Http\Models\Employees\LeaveCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeaveCategoryController extends Controller
{
    
    public function index(){

        try {
            
            $leave_category = LeaveCategory::all();

            $data['per_page'] = \Request::get('per_page') ?: 12;

            foreach ($leave_category as $leave){

                $cateory['leave_cat'][] = [
                    'category_name'=>$leave->category_name,
                    'leave_quantity'=>$leave->leave_quantity,
                    'start_date'=>$leave->start_date,
                    'status'=>$leave->status,
                    'monthly_relation'=>$leave->monthly_relation,
                    'id'=>$leave->id,
                ];
            }
            $data['per_page'] = \Request::get('per_page') ?: 12;
            return view('employees.leaves.leave_category.index', $cateory, $data);

        } catch (ModelNotFoundException $e) {
            
        }
    }

    public function create()
    {

        try {
            return view('employees.leaves.leave_category.create');
        } catch (ModelNotFoundException $e) {
            
        }
    }

    public function store(Request $request){

        try {

            $data = new LeaveCategory();

            $data->start_date = $request->input('start_date');
            $data->category_name = $request->input('category_name');
            $data->leave_quantity = $request->input('leave_quantity');
            $data->monthly_relation = $request->input('monthly_relation');
            $data->category_name = $request->input('category_name');
            $data->save();

            return redirect('hr/leave-category');

        } catch (ModelNotFoundException $e) {
            
        }
    }

    public function edit($id){

        try {
            $data['leave_category'] = LeaveCategory::where('id', $id)->first();
            return view('employees.leaves.leave_category.edit', $data);
        } catch (ModelNotFoundException $e) {
            
        }
    }

    public function update(Request $request, LeaveCategory $leaveCategory, $id){

        try {

            $data = LeaveCategory::find($id);

            $data->start_date = $request->input('start_date');
            $data->category_name = $request->input('category_name');
            $data->leave_quantity = $request->input('leave_quantity');
            $data->monthly_relation = $request->input('monthly_relation');
            $data->category_name = $request->input('category_name');
            $data->save();

            return redirect('hr/leave-category');

        } catch (ModelNotFoundException $e) {
            
        }
    }

    public function remove($id){
        try {
            
            \DB::table('tbl_leave_category')->where('id', '=', $id)->delete();
            return redirect('hr/leave-category');

        } catch (ModelNotFoundException $e) {
            
        }
    }
}