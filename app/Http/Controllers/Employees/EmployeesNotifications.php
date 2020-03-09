<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Database\Elqouent\ModelNotFoundException;
use App\Http\Models\Employees\Notifications;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Customlib;

class EmployeesNotifications extends Controller
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
            
            $data['per_page'] = \Request::get('per_page') ?: 12;
            $data['notifications'] = Notifications::whereType(1)->paginate();

            return view('employees/notification/index', $data);

        } catch (ModelNotFoundException $e) {
            return redirect('/');
        }
        
    }

   
    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Employees\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function show($id = NULL)
    {
        try {
            
            if(is_null($id)) return redirect('/');
            
            $data = [];
            $notification = Notifications::whereType(1)->findOrFail($id);


            $data['notification'] = [
                'title' => $notification->title,
                'datetime' => $this->custom->dateformat($notification->datetime),
                'description' => $notification->description
            ];

            if($notification->unread == 1){
                Notifications::whereId($id)->update(['unread' => '0']);
            }

            return view('employees/notification/view', $data);

           
        } catch (ModelNotFoundException $e) {
            return redirect('/');
        }
    }


}
