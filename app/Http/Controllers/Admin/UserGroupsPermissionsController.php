<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Usergroups;
use App\Http\Models\Admin\Permissions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;

class UserGroupsPermissionsController extends Controller
{


    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permissions:MANAGE_USERS_GROUPS');
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data['group'] = Usergroups::find($id);
        $data['allowed_permissions'] = unserialize($data['group']->permissions);
        $data['permissions'] = Permissions::all();

        return view('admin.users.permissions.manage', $data);
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

        try {

            $permissions = serialize($request->input('permissions'));
            $permission = Usergroups::find($id);
            $permission->permissions = $permissions;
            $result = $permission->save();
            if($result){
                $request->session()->flash('added', __('admin/permissions.added'));
            }

            return redirect('admin/manage-permissions/show/'.$id);

        } catch (ModelNotFoundException $e) {
            
        }
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
