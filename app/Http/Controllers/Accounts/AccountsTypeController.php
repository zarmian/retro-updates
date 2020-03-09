<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Models\Accounts\AccountsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccountsTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            $data[] = [];
            $types = AccountsType::where('parent', '0')->get();

            if(isset($types) && count($types) > 0)
            {
                foreach($types as $type)
                {

                    $children = [];
                    if(isset($type->children) && count($type->children) > 0)
                    {
                        foreach($type->children as $child)
                        {
                            $children[] = [
                                'type_id' => $child->id,
                                'name' => $child->name,
                                'parent' => $child->parent
                            ];
                        }
                    }

                    $data['types'][] = [
                        'type_id' => $type->id,
                        'name' => $type->name,
                        'parent' => $type->parent,
                        'children' => $children

                    ];

                }
            }

            return view('accounting.type.index', $data);

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
            $data[] = [];

            $types = AccountsType::where('parent', '0')->get();

            if(isset($types) && count($types) > 0)
            {
                foreach($types as $type)
                {

                    $children = [];
                    if(isset($type->children) && count($type->children) > 0)
                    {
                        foreach($type->children as $child)
                        {
                            $children[] = [
                                'type_id' => $child->id,
                                'name' => $child->name,
                                'parent' => $child->parent
                            ];
                        }
                    }

                    $data['types'][] = [
                        'type_id' => $type->id,
                        'name' => $type->name,
                        'parent' => $type->parent,
                        'children' => $children

                    ];

                }
            }


            return view('accounting.type.create', $data);
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
                'name' => 'required',
                'parent' => 'required'
            ]);

            $type = new AccountsType;
            $type->name = $request->input('name');
            $type->parent = $request->input('parent');
            $type->type = $request->input('type');
            $type->save();
           

            if($type){
                $request->session()->flash('msg', __('admin/accounting.type_added'));
            }

            return redirect('accounting/chart-type/add');

            
        } catch (ModelNotFoundException $e) {
            
        }
    }

  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Accounts\AccountsType  $accountsType
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountsType $accountsType, $id=NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/chart-type');

            $data[] = [];

            $data['account'] = $accountsType->whereId($id)->first();
            
            if(!isset($data['account']) && count($data['account']) === 0){
                return redirect('accounting/chart-type');
            }

            $types = AccountsType::where('parent', '0')->get();

            if(isset($types) && count($types) > 0)
            {
                foreach($types as $type)
                {

                    $children = [];
                    if(isset($type->children) && count($type->children) > 0)
                    {
                        foreach($type->children as $child)
                        {
                            $children[] = [
                                'type_id' => $child->id,
                                'name' => $child->name,
                                'parent' => $child->parent
                            ];
                        }
                    }

                    $data['types'][] = [
                        'type_id' => $type->id,
                        'name' => $type->name,
                        'parent' => $type->parent,
                        'children' => $children

                    ];

                }
            }
            
            return view('accounting.type.edit', $data);

        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Accounts\AccountsType  $accountsType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/chart-type');

            $type = AccountsType::findOrFail($id);
            
            $this->validate($request, [
                'name' => 'required',
                'parent' => 'required'
            ]);

            if($request->input('parent') > 0){
                $update_type = AccountsType::whereId($request->input('parent'))->first();
                if($type->parent == 0 && $update_type->parent != 0){

                    $request->session()->flash('error', __('admin/accounting.type_parent_error'));
                    return redirect('accounting/chart-type/edit/'.$id);
                }
            }
            

            $type->name = $request->input('name');
            $type->parent = $request->input('parent');
            $type->type = $request->input('type');
            $type->save();
           

            if($type){
                $request->session()->flash('msg', __('admin/accounting.type_updated'));
            }

            return redirect('accounting/chart-type/edit');

        } catch (ModelNotFoundException $e) {
            
        }
    }

}
