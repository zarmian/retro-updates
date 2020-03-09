<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Models\Accounts\AccountsChart;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Employees;
use Illuminate\Support\Facades\Storage;
use App\Http\Models\Auth\AuthRole;
use Validator;
use Auth;
use DB;

class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $default =  Auth::guard('auth')->user()->roles->default;
        $user_id = Auth::guard('auth')->user()->id;
        $data['per_page'] = \Request::get('per_page') ?: 12;

        $employees = Employees::query();
        if($default <> 1)
        {
            $employees->where('create_by', $user_id);
        }
        $data['users'] = $employees->where('role', '1')->orderBy('id')->paginate($data['per_page']);
        
        return view('admin.users.accounts.manage', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = array();

        $account = AccountsChart::orWhere('type_id', '11')
            ->orWhere('type_id', '10')
            ->orWhere('type_id', '5')
            ->orderBy('code', 'DESC')
            ->first();

        $data['code'] = '';
        if(isset($account) && count($account) > 0)
        {
            $account_code = $account->code+1;
            $data['code'] = '0'.$account_code;
        }

        $data['genders'] = DB::table('tbl_gender')->select('id','title')->get();
        $data['groups'] = AuthRole::where('default', '1')->get();
        $data['countries'] = DB::table('tbl_countries')->select('id', 'country_name')->get();

        return view('admin.users.accounts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'employee_code' => 'required|unique:tbl_employees',
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:tbl_employees',
            'email' => 'required|email|unique:tbl_employees',
            'password' => 'required|confirmed|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'group' => 'required',
            'status' => 'required',
            'avatar' => 'mimes:jpeg,png,jpg,gif'
        ]);

        // checking if validation fails
        if ($validator->fails()) {
            return redirect('/manage-users/create')
                ->withErrors($validator)
                ->withInput();
        }

        $employee_code = $request->input('employee_code');

        $create_by = Auth::guard('auth')->user()->id;

        $avatar = $request->file('avatar');
        $remember_token = str_random(60);

        $user = new Employees();

        $user->employee_code = $employee_code;
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->username = $request->input('username');
        $user->phone_no = $request->input('phone');
        $user->email = $request->input('email');
        $user->gender = $request->input('gender');
        $user->mobile_no = $request->input('cell');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('group');
        $user->nationality = $request->input('nationality');
        $user->present_address = $request->input('present_address');
        $user->permanant_address = $request->input('permanant_address');
        $user->reference = $request->input('reference');

        $user->national_id = '';
      
        $user->date_of_birth = '1990-10-10';
        $user->joining_date = '1990-10-10';
        $user->department_id = '0';
        $user->designation_id = '0';
        $user->shift_id = '0';
        $user->employee_type = '0';

        $user->salary_type = '0';
        $user->basic_salary = '0';
        $user->accomodation_allowance = '0';
        $user->medical_allowance = '0';
        $user->house_rent_allowance = '0';
        $user->transportation_allowance = '0';
        $user->food_allowance = '0';

        $user->overtime_1 = '0';
        $user->overtime_2 = '0';
        $user->overtime_3 = '0';

        $user->create_by = $create_by;
        $user->create_ip = $request->ip();
        $user->status = $request->input('status');
        $user->remember_token = $remember_token;

        if($avatar){
            
            $file_extension = $avatar->getClientOriginalExtension();
            $destinationPath = storage_path().'/app/avatar/';
            $filename = 'avatar_'.strtotime(date('Y-m-d H:i:s')).'.'.$file_extension;
            $avatar->move($destinationPath, $filename);
            $user->image = $filename;
        }
        
        $result = $user->save();
        if($result){

            $account = new AccountsChart;
            $account->code = $employee_code;
            $account->name = $request->input('first_name').' '.$request->input('last_name');
            $account->type_id = '11';
            $account->opening_balance = '0';
            $account->balance_type = 'cr';
            $account->is_systemize = '0';
            $account->save();

            $request->session()->flash('msg', __('admin/users.added_msg'));
        }

        return redirect('/manage-users/create');

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

            if (is_null($id)) { return redirect('/manage-users'); }
            $data = array();

            $data['user'] = Employees::where('role', '1')->findOrFail($id);
            $data['groups'] = AuthRole::where('default', 1)->get();

            $data['countries'] = DB::table('tbl_countries')->select('id', 'country_name')->get();
            
        
            return view('admin.users.accounts.edit', $data);

        } catch (ModelNotFoundException $e) {
            return redirect('/manage-users');
        }
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

        if (is_null($id)) { return redirect('/manage-users'); }

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:tbl_users,email,'.$id,
            'password' => 'confirmed',
            'group' => 'required',
            'status' => 'required',
            'avatar' => 'mimes:jpeg,png,jpg,gif'
        ];
        

        if($request->input('password')){
            $rules['password'] .= '|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/';
        }

        $this->validate($request, $rules);

        $avatar = $request->file('avatar');
        $remember_token = str_random(60);

        $user = Employees::where('role', '1')->findOrFail($id);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->phone_no = $request->input('phone');
        $user->mobile_no = $request->input('cell');
        $user->role = $request->input('group');
        $user->nationality = $request->input('nationality');
        $user->present_address = $request->input('present_address');
        $user->permanant_address = $request->input('permanant_address');
        $user->reference = $request->input('reference');
        $user->status = $request->input('status');
        $user->remember_token = $remember_token;

        if($request->input('password')){
            $user->password = bcrypt($request->input('password'));
        }

        if($avatar){
            Storage::delete('avatar/'.$user->image);
            $file_extension = $avatar->getClientOriginalExtension();
            $destinationPath = storage_path().'/app/avatar/';
            $filename = 'avatar_'.strtotime(date('Y-m-d H:i:s')).'.'.$file_extension;
            $avatar->move($destinationPath, $filename);
            $user->image = $filename;
        }

        $result = $user->save();
        if($result){
            $request->session()->flash('msg', __('admin/users.update_msg'));
        }

        return redirect('/manage-users/edit/'.$id);

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
        try {
            if (is_null($id)) { return redirect('/manage-users'); }

            $user = Employees::where('role', '1')->findOrFail($id);
            
            $exists = Storage::exists('avatar/'.$user->image);

            if(!is_null($user->image) && $exists){
                Storage::delete('avatar/'.$user->image);
            }
           
            $result = Users::destroy($id);
            if($result){
                session()->flash('msg', __('admin/users.delete_msg'));
            }

            return redirect('/manage-users');
            
        } catch (ModelNotFoundException $e) {
            return redirect('/manage-users');
        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    public function ajax(Request $request)
    {

        try {

            if($request->ajax()){

                $action = $request->input('action');
                switch ($action) {
                    case 'upload_cover':
                      
                    break;

                    
                    default:
                    break;
                }
            
            }
        
        } catch (ModelNotFoundException $e) {
            
        }
    }
}
