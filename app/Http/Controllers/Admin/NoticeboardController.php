<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Employees\Notifications;
use App\Jobs\SendNoticeBoardEmailJob;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Employees;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Auth;


class NoticeboardController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
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
            $data['notices'] = [];

            $data['per_page'] = \Request::get('per_page') ?: 12;

            $qry = Notifications::query();

            if(\Request::has('title'))
            {
                $title = \Request::get('title');
                $qry->where('title', 'LIKE', "%$title%");
            }elseif(\Request::has('date'))
            {
                $nice_date = Carbon::createFromFormat('m/d/Y', \Request::get('date'))->toDateString();
                $qry->whereDate('datetime', $nice_date);
            }

            $notices = $qry->whereType('1')->orderBy('datetime', 'DESC')->paginate($data['per_page']);

            if(isset($notices) && count($notices) > 0)
            {
                foreach($notices as $notice)
                {
                    $data['notices'][] = [
                        'id' => $notice['id'],
                        'datetime' => date('l, F d Y', strtotime($notice['datetime'])),
                        'title' => $notice['title'],
                        'description' => $notice['description']
                    ];
                }
            }


            $data['pages'] = $notices->appends(\Input::except('page'))->render();

            return view('admin.noticeboard.index', $data);
            
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

            return view('admin.noticeboard.create');
            
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
                'date' => 'required',
                'title' => 'required'
            ]);

            $notice = new Notifications();

            $nice_date = Carbon::createFromFormat('m/d/Y', $request->input('date'))->toDateString();


            $notice->datetime = $nice_date;
            $notice->title = $request->input('title');
            $notice->description = $request->input('description');
            $notice->type = '1';
            $notice->added_by = Auth::guard('auth')->user()->id;
            $notice->save();

            if($notice)
            {

                $enable_email = $this->custom->getSetting('ENABLE_EMAIL');
                if(isset($enable_email) && $enable_email == 'true')
                {
                    $dd = [
                        'title' => $request->input('title'),
                        'date' => $this->custom->dateformat($nice_date),
                        'description' => $request->input('description'),
                    ];

                    $job = (new SendNoticeBoardEmailJob($dd))->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                }

                $request->session()->flash('msg', __('admin/common.noticeboard_added_message'));
            }
          
            return redirect('/noticeboard/create');
            
        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = '')
    {
        try {

            if(is_null($id)) return view('admin.noticeboard.show');

            $noticeboard = Notifications::findorFail($id);

            $data['noticeboard'] = [
                'date' => $noticeboard['datetime'],
                'title' => $noticeboard['title'],
                'description' => $noticeboard['description']
            ];

            return view('admin.noticeboard.show', $data);
            
        } catch (ModelNotFoundException $e) {
            return view('admin.noticeboard.show');
        }
    }

}
