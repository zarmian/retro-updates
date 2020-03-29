<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Models\Accounts\Product;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Validator;
use Storage;
use Auth;
use DB;
use PDF;
use URL;

class ProductController extends Controller
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
            $data['product'] = [];
            
            $data['per_page'] = \Request::get('per_page') ?: 12;

            $qry = Product::query();

            if(\Request::has('name'))
            {
                $name = \Request::get('name');
                $qry->where('name', 'LIKE', "%$name%");
            }

        
            
            $qry->orderBy('id', 'DESC');
            $products = $qry->paginate($data['per_page']);

            
            if(isset($products) )
            {
                foreach($products as $product)
                {
                    $data['product'][] = [
                        'id' => $product->id,
                        'name' => $product->name,
                    ];
                }
            }

            $data['pages'] = $products->appends(\Input::except('page'))->render();
           

            return view('accounting/products/index', $data);
            
        } 
        catch (ModelNotFoundException $e) {
            
            
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


            return view('accounting/products/create');

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
                'name' => 'required',
                
            ]);

         

            $product = new Product;
            $product->name = $request->input('name');
      
            $product->save();


            $request->session()->flash('msg', __('Product has been added successfully.'));
            return redirect('accounting/products/add');
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/sales');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
