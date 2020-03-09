<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Admin\EmailTemplates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Storage;

class EmailTemplatesController extends Controller
{
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
            $data['templates'] = EmailTemplates::paginate($data['per_page']);

            return view('admin.templates.email.index', $data);

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

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Admin\EmailTemplates  $emailTemplates
     * @return \Illuminate\Http\Response
     */
    public function edit($id = NULL)
    {
        try {

            if(is_null($id)) return redirect('/email/templates');

            $template = EmailTemplates::findOrFail($id);

            $content =  Storage::get('templates/'.$template->file_name);
            
            $content2 = Storage::disk('local')->get('templates/'.$template->file_name);

            $data['template'] = [
                'id' => $template->id,
                'title' => $template->title,
                'subject' => $template->subject,
                'status' => $template->status,
                'file_name' => $template->file_name,
                'body' => $content,
                'body2' => $content2,
                'variables' => $template->variables,
            ];

          

            return view('admin.templates.email.edit', $data);

        } catch (ModelNotFoundException $e) {
            return redirect('/email/templates');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Admin\EmailTemplates  $emailTemplates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = NULL)
    {
        try {

            if(is_null($id)) return redirect('/email/templates');

            $this->validate($request, [
                'title' => 'required',
                'subject' => 'required'
            ]);

            $template = EmailTemplates::findOrFail($id);

            $template->title = $request->input('title');
            $template->subject = $request->input('subject');
            $template->status = $request->input('status');
            $template->save();

            $content = $request->input('body');

            Storage::disk('local')->put('templates/'.$template->file_name, $content);

            $request->session()->flash('msg', __('admin/email.template_updated_msg'));
            return redirect('/email/templates/edit/'.$id);

        } catch (ModelNotFoundException $e) {
            return redirect('/email/templates');
        }
    }

}
