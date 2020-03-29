<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Models\Accounts\Destination;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Validator;
use Storage;
use Auth;
use DB;
use PDF;
use URL;

class DestinationController extends Controller
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

            $qry = Destination::query();

            if(\Request::has('destination'))
            {
                $name = \Request::get('destination');
                $qry->where('destination', 'LIKE', "%$name%");
            }

        
            
            $qry->orderBy('id', 'DESC');
            $sales = $qry->paginate($data['per_page']);


            if(isset($sales) )
            {
                foreach($sales as $sale)
                {
                    $data['items'][] = [
                        'id' => $sale->id,
                        'destination' => $sale->destination,
                        
                    ];
                }
            }

            $data['pages'] = $sales->appends(\Input::except('page'))->render();

            return view('accounting/destination/index', $data);
            
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


            return view('accounting/destination/create');

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
                'destination' => 'required',
                
            ]);

         

            $sale = new Destination;
            $sale->destination = $request->input('destination');
      
            $sale->save();


            $request->session()->flash('msg', __('Destination has been added successfully.'));
            return redirect('accounting/destination/add');
            
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

            if(is_null($id)) return redirect('accounting/destination');

            $data = [];
            $data['product'] = Trucks::findOrFail($id);

            return view('accounting/destination/edit', $data);
            
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

            if(is_null($id)) return redirect('accounting/destination');

            $this->validate($request, [
                'destination' => 'required',
                
            ]);


            $sale = Destination::findOrFail($id);

            $sale->destination = $request->input('destination');
            $sale->save();



            $request->session()->flash('msg', __('Destination has been updated successfully.'));
            return redirect('accounting/destination/edit/'.$id);
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/destination');
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

            if(is_null($id)) return redirect('accounting/destination');

            $sale = Destination::findOrFail($id);
            $delete = $sale->delete();
            if($sale)
            {
                \Request::session()->flash('msg', __('Destination has been deleted successfully.'));
            }

            return redirect('accounting/destination');

        } catch (ModelNotFoundException $e) {
             return redirect('accounting/destination');
        }
    }

}
