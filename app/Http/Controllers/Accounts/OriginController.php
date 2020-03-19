<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Models\Accounts\Origin;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Validator;
use Storage;
use Auth;
use DB;
use PDF;
use URL;

class OriginController extends Controller
{
    public function __construct()
    {
        $this->custom = new Customlib();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $data = [];
            $data['sales'] = [];

            $data['per_page'] = \Request::get('per_page') ?: 12;

            $qry = Origin::query();

            if(\Request::has('origin'))
            {
                $name = \Request::get('origin');
                $qry->where('origin', 'LIKE', "%$name%");
            }

        
            
            $qry->orderBy('id', 'DESC');
            $sales = $qry->paginate($data['per_page']);


            if(isset($sales) )
            {
                foreach($sales as $sale)
                {
                    $data['origin'][] = [
                        'id' => $sale->id,
                        'origin' => $sale->origin,
                        
                    ];
                }
            }
            
            $data['pages'] = $sales->appends(\Input::except('page'))->render();
            
            return view('accounting/origin/index', $data);
            
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

            $data = [];


            return view('accounting/origin/create');

        } catch (ModelNotFoundException $e) {
            return redirect('accounting/sales');
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
                'origin' => 'required',
                
            ]);

         

            $sale = new Origin;
            $sale->origin = $request->input('origin');
      
            $sale->save();


            $request->session()->flash('msg', __('Product has been added successfully.'));
            return redirect('accounting/origin/add');
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/sales');
        }
    }

   


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit($id = NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/origin');

            $data = [];
            $data['product'] = Items::findOrFail($id);

            return view('accounting/origin/edit', $data);
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/sales');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Accounts\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/origin');

            $this->validate($request, [
                'origin' => 'required',
                
            ]);


            $sale = Origin::findOrFail($id);

            $sale->origin = $request->input('origin');
            $sale->save();



            $request->session()->flash('msg', __('origin has been updated successfully.'));
            return redirect('accounting/origin/edit/'.$id);
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/origin');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Accounts\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/origin');

            $sale = Origin::findOrFail($id);
            $delete = $sale->delete();
            if($sale)
            {
                \Request::session()->flash('msg', __('origin has been deleted successfully.'));
            }

            return redirect('accounting/origin');

        } catch (ModelNotFoundException $e) {
             return redirect('accounting/origin');
        }
    }

}
