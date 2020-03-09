<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Shift;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class ShiftController extends Controller
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
        $data['shifts'] = Shift::paginate($data['per_page']);

        return view('admin.shift.manage', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shift.create');
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
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $description = $request->input('description');
        $status = $request->input('status');

        $start_time = Carbon::parse($request->input('start_time'));
        $end_time = Carbon::parse($request->input('end_time'));

        $shift = new Shift;
        $shift->title = $request->input('title');
        $shift->description = $description;
        $shift->start_time = $start_time->toTimeString(); 
        $shift->end_time = $end_time->toTimeString();
        $shift->status = $status;
        $result = $shift->save();
        if($result){
            $request->session()->flash('msg', __('admin/shift.added'));
        }
            
        return redirect('/shift/create');
        
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = NULL)
    {

        try {

            if(is_null($id)){ return redirect('/shift'); }

            $data['shift'] = Shift::findOrFail($id);
            return view('admin.shift.edit', $data);

        } catch (ModelNotFoundException $e) {
            return redirect('/shift');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = NULL)
    {
        try {

            if(is_null($id)){ return redirect('/shift'); }

            $this->validate($request, [
                'title' => 'required',
                'start_time' => 'required',
                'end_time' => 'required'
            ]);

            $description = $request->input('description');
            $status = $request->input('status');

            $start_time = Carbon::parse($request->input('start_time'));
            $end_time = Carbon::parse($request->input('end_time'));

            $shift = Shift::findOrFail($id);
            $shift->title = $request->input('title');
            $shift->description = $description;
            $shift->start_time = $start_time->toTimeString(); 
            $shift->end_time = $end_time->toTimeString();
            $shift->status = $status;
            $result = $shift->save();
            if($result){
                $request->session()->flash('msg', __('admin/shift.update'));
            }
                
            return redirect('/shift/edit/'.$id);

        } catch (ModelNotFoundException $e) {
            return redirect('/shift');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = NULL)
    {
        if(is_null($id)){ return redirect('/shift'); }
        $result = Shift::destroy($id);
        if($result){
            session()->flash('msg', __('admin/shift.remove'));
        }

        return redirect('/shift');

    }
}
