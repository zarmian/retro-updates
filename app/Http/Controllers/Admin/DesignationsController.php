<?php
namespace App\Http\Controllers\Admin;

use App\Http\Models\Admin\Designations;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;//find or fail error exception class.

class DesignationsController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['per_page'] = \Request::get('per_page');

        $data['designations'] = Designations::paginate($data['per_page']);
        return view('admin.designations.manage', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.designations.create');
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
                'title' => 'required',
                'status' => 'required'
            ]);

            $title = $request->input('title');
            $description = $request->input('description');
            $status = $request->input('status');

            $designation = new Designations;
            $designation->title = $title;
            $designation->description = $description;
            $designation->status = $status;
            $result = $designation->save();
            if($result){
                $request->session()->flash('msg', __('admin/designations.added'));
            }

            return redirect('/designations/create');

        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Admin\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function show(Designations $designations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Admin\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function edit(Designations $designations, $id=NULL)
    {

        try {
            if(is_null($id)){ return redirect('/designations'); }

            $data['designation'] = $designations->findOrFail($id);
            return view('admin.designations.edit', $data);
            
        } catch (ModelNotFoundException $e) {
           return redirect('/designations'); 
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Admin\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Designations $designations, $id = NULL)
    {
        try {

            if(is_null($id)){ return redirect('/designations'); }

            $this->validate($request, [
                'title' => 'required',
                'status' => 'required'
            ]);

            $title = $request->input('title');
            $description = $request->input('description');
            $status = $request->input('status');

            $designation = $designations->findOrFail($id);
            $designation->title = $title;
            $designation->description = $description;
            $designation->status = $status;
            $result = $designation->save();
            if($result){
                $request->session()->flash('msg', __('admin/designations.update'));
            }
            return redirect('/designations/edit/'.$id);

        } catch (ModelNotFoundException $e) {
            return redirect('/designations'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Admin\Designations  $designations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designations $designations, $id)
    {
        try {
            if(is_null($id)){ return redirect('/designations'); }

            $designation = $designations->findOrFail($id);
            $result = $designations->destroy($designation->id);
            if($result){
                session()->flash('msg', __('admin/designations.remove'));
            }

            return redirect('/designations');

        } catch (ModelNotFoundException $e) {
            return redirect('/designations');
        }
    }
}
