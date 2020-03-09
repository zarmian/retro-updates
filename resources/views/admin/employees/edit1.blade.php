@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/employees.update')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ route('admin') }}">@lang('admin/dashboard.dashboard-heading')</a>  /
        <a href="{{ url('admin/employees') }}">@lang('admin/employees.manage')</a>  /
        <a href="#" class="active">@lang('admin/employees.update')</a>
      </div>
    </div>
  </div>
</section>
@endsection
@section('content')
<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
      
      <div id="products" class="row list-group">
        
        <div class="item col-sm-8 col-sm-offset-2">
          <div class="">
            <div class="row">
              @if(Session::has('msg'))
              <div class="alert alert-success">
                {{ Session::get('msg') }}
              </div>
              @endif
              
              @if(isset($errors) && count($errors) > 0)
              <div class="alert alert-danger">
                <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
              
              <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">@lang('admin/employees.update')</div>
                  <div class="panel-body">
                    <style type="text/css">
                      #accountForm {
                        margin-top: 15px;
                      }
                    </style>
                    <ul class="nav nav-tabs">
                      <li class="active">
                        <a href="#info-tab" data-toggle="tab">@lang('admin/employees.info_tab') <i class="fa"></i></a>
                      </li>
                      <li><a href="#qualification-tab" data-toggle="tab">@lang('admin/employees.qualification_tab')</a></li>
                      <li>
                        <a href="#experience-tab" data-toggle="tab">@lang('admin/employees.work_experience') <i class="fa"></i></a>
                      </li>

                      <li>
                        <a href="#salary-tab" data-toggle="tab">@lang('admin/employees.salary') <i class="fa"></i></a>
                      </li>
                    </ul>
                    <form id="accountForm" method="post" class="form-" action="{{ url('admin/employees/update', $employee->id) }}" style="margin-top: 20px;" enctype="multipart/form-data">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="tab-content">

                        <div class="tab-pane active" id="info-tab">

                          <div class="form-group col-sm-12 no-padding">
                            <label for="employee_code">@lang('admin/employees.employee_code_label')</label>
                            <input type="text" name="employee_code" id="employee_code" class="form-control" value="{{ $employee->employee_code }}" required="required" />
                          </div>

                          <div class="form-group col-sm-6 no-padding-left">
                            <label for="first_name">@lang('admin/employees.first_name_label')</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $employee->first_name }}" required="required" />
                          </div>

                          <div class="form-group col-sm-6 no-padding">
                            <label for="last_name">@lang('admin/employees.last_name_label')</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $employee->last_name }}" required="required">
                          </div>

                          <div class="form-group col-sm-12 no-padding">
                            <label for="username">@lang('admin/employees.username_label')</label>
                            <input type="text" name="username" id="username" class="form-control" value="{{ $employee->username }}" disabled="disabled" required="required" />
                          </div>

                          <div class="form-group col-sm-6 no-padding-left">
                            <label for="password">@lang('admin/employees.password_label')</label>
                            <input type="password" name="password" id="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" />

                            <span class="help-block">@lang('admin/employees.password_note')</span>
                          </div>

                          <div class="form-group col-sm-6 no-padding">
                            <label for="password_confirmation">@lang('admin/employees.c_password_label')</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" />
                            
                            <span class="help-block">@lang('admin/employees.password_note')</span>
                          </div>

                          <div class="form-group col-sm-6 no-padding-left">
                        <label for="email">@lang('admin/employees.email_label')</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $employee->email }}" required="required" data-bv-emailaddress-message="The input is not a valid email address" />
                      </div>

                      <div class="form-group col-sm-6 no-padding">
                        <label for="national_id">@lang('admin/employees.national_id_label')</label>
                        <input type="text" name="national_id" id="national_id" class="form-control" value="{{ $employee->email }}" />
                      </div>

                      <div class="form-group col-sm-6 no-padding-left">
                        <label for="fathers_name">@lang('admin/employees.fathers_name_label')</label>
                        <input type="text" name="fathers_name" id="fathers_name" class="form-control" value="{{ $employee->fathers_name }}" />
                      </div>


                      <div class="form-group col-sm-6 no-padding">
                        <label for="mothers_name">@lang('admin/employees.mothers_name_label')</label>
                        <input type="text" name="mothers_name" id="mothers_name" class="form-control" value="{{ $employee->monthers_name }}" />
                      </div>

                      <div class="form-group col-sm-6 no-padding-left">
                        <label for="gender">@lang('admin/employees.gender_label')</label>
                        
                        @if(isset($genders) && count($genders) > 0)
                          <select name="gender" id="gender" class="form-control" required="required">
                            @foreach($genders as $gender)
                              @if($gender->id == $employee->gender)
                                <option value="{{ $gender->id }}" selected="selected">{{ $gender->title }}</option>
                              @else
                                <option value="{{ $gender->id }}">{{ $gender->title }}</option>
                              @endif
                            @endforeach
                          </select>
                        @endif
                      </div>

  
                      <div class="form-group col-sm-6 no-padding">
                        <label for="marital_status">@lang('admin/employees.marital_status_label')</label>
                        @if(isset($maritals) && count($maritals) > 0)
                          <select name="marital_status" id="marital_status" class="form-control" required="required">
                            @foreach($maritals as $marital)
                              @if($marital->id == $employee->maritial_status)
                                <option value="{{ $marital->id }}" selected="selected">{{ $marital->title }}</option>
                              @else
                                <option value="{{ $marital->id }}">{{ $marital->title }}</option>
                              @endif
                            @endforeach
                          </select>
                        @endif
                      </div>


                      <div class="form-group col-sm-6 no-padding-left">
                        <label for="phone">@lang('admin/employees.phone_label')</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ $employee->phone_no }}" required="required" />
                      </div>


                      <div class="form-group col-sm-6 no-padding">
                        <label for="mobile">@lang('admin/employees.mobile_label')</label>
                        <input type="text" name="mobile" id="mobile" class="form-control" value="{{ $employee->mobile_no }}" />
                      </div>

                      <div class="form-group col-sm-6 no-padding-left">
                        <label for="date_of_birth">@lang('admin/employees.date_of_birth_label')</label>
                        <input type="text" name="date_of_birth" id="date_of_birth" class="datepicker form-control" data-default-date="{{ $employee->convertdate($employee->date_of_birth) }}" value="" required="required" />
                      </div>


                      <div class="form-group col-sm-6 no-padding">
                        <label for="joining_date">@lang('admin/employees.joining_date_label')</label>
                        <input type="text" name="joining_date" id="joining_date" class="datepicker form-control" data-default-date="{{ $employee->convertdate($employee->joining_date) }}" value="" required="required" />
                      </div>

                      <div class="form-group col-sm-6 no-padding-left">
                        <label for="department_id">@lang('admin/employees.department_label')</label>
                        
                          <select name="department_id" id="department_id" class="form-control" required="required">
                            <option value="">@lang('admin/employees.select_combo')</option>
                            @if(isset($departments) && count($departments) > 0)
                              @foreach($departments as $department)
                                @if($department->id == $employee->department_id)
                                  <option value="{{ $department->id }}" selected="selected">{{ $department->title }}</option>
                                @else
                                  <option value="{{ $department->id }}">{{ $department->title }}</option>
                                @endif
                              @endforeach
                            @endif
                          </select>
                        
                      </div>


                      <div class="form-group col-sm-6 no-padding">
                        <label for="designation_id">@lang('admin/employees.designation_label')</label>
                        
                          <select name="designation_id" id="designation_id" class="form-control" required="required">
                            <option value="">@lang('admin/employees.select_combo')</option>
                            @if(isset($designations) && count($designations) > 0)
                              @foreach($designations as $designation)
                                @if($designation->id == $employee->designation_id)
                                  <option value="{{ $designation->id }}" selected="selected">{{ $designation->title }}</option>
                                @else
                                  <option value="{{ $designation->id }}">{{ $designation->title }}</option>
                                @endif
                              @endforeach
                            @endif
                          </select>
                        
                      </div>


                      <div class="form-group col-sm-6 no-padding-left">
                        <label for="shift_id">@lang('admin/employees.shift_label')</label>
                        
                          <select name="shift_id" id="shift_id" class="form-control" required="required">
                            <option value="">@lang('admin/employees.select_combo')</option>
                            @if(isset($shifts) && count($shifts) > 0)
                              @foreach($shifts as $shift)
                                @if($shift->id == $employee->shift_id)
                                  <option value="{{ $shift->id }}" selected="selected">{{ $shift->title }}</option>
                                @else
                                  <option value="{{ $shift->id }}">{{ $shift->title }}</option>
                                @endif
                              @endforeach
                            @endif
                          </select>
                       
                      </div>



                      <div class="form-group col-sm-6 no-padding">
                          <label for="employee_type">@lang('admin/employees.employee_type_label')</label>
                          <select name="employee_type" id="employee_type" class="form-control" required="required">
                            <option value="">@lang('admin/employees.select_combo')</option>
                            @if(isset($types) && count($types) > 0)
                              @foreach($types as $type)
                                @if($type->id == $employee->employee_type)
                                  <option value="{{ $type->id }}" selected="selected">{{ $type->title }}</option>
                                @else
                                  <option value="{{ $type->id }}">{{ $type->title }}</option>
                                @endif
                              @endforeach
                            @endif
                        </select>
                      </div>


                      <div class="form-group col-sm-12 no-padding">
                         <label for="reference">@lang('admin/employees.reference_label')</label>
                         <input type="text" name="reference" id="reference" class="form-control" value="{{ $employee->reference }}" />
                      </div>


                      <div class="form-group col-sm-6 no-padding-left">
                        <label for="present_address">@lang('admin/employees.present_address_label')</label>
                        <textarea name="present_address" id="present_address" cols="30" rows="3" class="form-control">{{ $employee->present_address }}</textarea>
                        
                      </div>


                      <div class="form-group col-sm-6 no-padding">
                        <label for="permanant_address">@lang('admin/employees.permanant_address_label')</label>
                        <textarea name="permanant_address" id="permanant_address" cols="30" rows="3" class="form-control">{{ $employee->permanant_address }}</textarea>
                        
                      </div>

                      <div class="form-group col-sm-12 no-padding">
                        <label for="avatar">@lang('admin/employees.avatar_label')</label>
                        <input type="file" name="avatar" id="avatar" />
                      </div>


                      <div class="form-group col-sm-6 no-padding-left">
                        <label for="group">@lang('admin/employees.role_label')</label>
                        <select name="group" id="group" class="form-control" required="required">
                          <option value="">@lang('admin/employees.select_combo')</option>

                          @if(isset($roles) && count($roles) > 0)
                            @foreach($roles as $role)
                              @if($role->id == $employee->role)
                                <option value="{{ $role->id }}" selected="selected">{{ $role->title }}</option>
                              @else
                                <option value="{{ $role->id }}">{{ $role->title }}</option>
                              @endif
                            @endforeach
                          @endif

                        </select>
                      </div>

                      <div class="form-group col-sm-6 no-padding">
                        <label for="status">@lang('admin/employees.status_label')</label>
                        <select name="status" id="status" class="form-control" required="required">
                          <option value="">@lang('admin/employees.select_combo')</option>
                          <option value="1" @if($employee->status == 1) selected="selected" @endif>Active</option>
                          <option value="0" @if($employee->status == 0) selected="selected" @endif>InActive</option>
                        </select>
                      </div>


                      </div>


                      <div class="tab-pane" id="qualification-tab">

                      <div class="form-group col-sm-12 no-padding text-right">
                        <a href="javascript:void(0)" class="btn btn-xs btn-primary new_row" >ADD</a>
                      </div>
  

                      <div class="form-group col-sm-2 no-padding-left no_bottom_margin">
                         <label for="degree">@lang('admin/employees.degree_label')</label>
                      </div>

                      <div class="form-group col-sm-2 no-padding no_bottom_margin">
                         <label for="year">@lang('admin/employees.year_label')</label>
                      </div>

                      <div class="form-group col-sm-2 no_bottom_margin">
                         <label for="total_marks">@lang('admin/employees.total_marks_label')</label>
                      </div>

                      <div class="form-group col-sm-2 no-padding-left no_bottom_margin">
                         <label for="obtain_marks">@lang('admin/employees.obtain_marks_label')</label>
                      </div>


                      <div class="form-group col-sm-1 no-padding-left no_bottom_margin">
                         <label for="grade">@lang('admin/employees.grade_label')</label>  
                      </div>

                      <div class="form-group col-sm-3 no-padding no_bottom_margin">
                         <label for="institute">@lang('admin/employees.institute_label')</label>
                      </div>

                      
                        
                        @if(isset($qualifications) && count($qualifications) > 0)
                          @foreach($qualifications as $qualification)

                           <div class="q_row_{{ $qualification->id+100 }}">
                               <div class="form-group col-sm-2 no-padding-left">
                                 <input type="text" name="degree[]" id="degree" class="form-control" value="{{ $qualification->degree_name }}"  />
                              </div>

                              <div class="form-group col-sm-2 no-padding">
                                <select name="year[]" id="year" class="form-control">
                                  @for($i=1985; $i<=date('Y'); $i++)
                                    @if($i == $qualification->year)
                                      <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                                    @else
                                      <option value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                  @endfor
                                </select>
                              </div>

                              <div class="form-group col-sm-2">
                                <input type="text" name="total_marks[]" id="total_marks" class="form-control" value="{{ $qualification->total_marks }}" />
                              </div>

                              <div class="form-group col-sm-2 no-padding-left">
                                
                                 <input type="text" name="obtain_marks[]" id="obtain_marks" class="form-control" value="{{ $qualification->obtain_marks }}" />
                              </div>


                              <div class="form-group col-sm-1 no-padding-left">
                                
                                 <select name="grade[]" id="grade" class="form-control" style="padding: 0px !important;">
                                   <option value="A+" @if($qualification->grade == 'A+') selected="selected" @endif>A+</option>
                                   <option value="A" @if($qualification->grade == 'A') selected="selected" @endif>A</option>
                                   <option value="B+" @if($qualification->grade == 'B+') selected="selected" @endif>B+</option>
                                   <option value="B" @if($qualification->grade == 'B') selected="selected" @endif>B</option>
                                   <option value="C" @if($qualification->grade == 'C') selected="selected" @endif>C</option>
                                   <option value="D" @if($qualification->grade == 'D') selected="selected" @endif>D</option>
                                   <option value="E" @if($qualification->grade == 'E') selected="selected" @endif>E</option>
                                   <option value="F" @if($qualification->grade == 'F') selected="selected" @endif>F</option>
                                 </select>
                              </div>

                              <div class="form-group col-sm-2 no-padding">
                                 <input type="text" name="institute[]" id="institute" class="form-control" value="{{ $qualification->institute }}" />
                              </div>

                              <div class="form-group col-sm-1">
                                <input type="button" data-row-id="{{ $qualification->id+100 }}" data-id="{{ $qualification->id }}" class="btn btn-danger delete_row" value="DEL" />
                              </div>
                           </div>

                          @endforeach
                        @endif

                        
                      

                      <div class="form-group col-sm-2 no-padding-left">
                       
                         <input type="text" name="degree[]" id="degree" class="form-control" value=""  />
                      </div>

                      <div class="form-group col-sm-2 no-padding">
                         
                         <select name="year[]" id="year" class="form-control">
                           @for($i=1985; $i<=date('Y'); $i++)
                             <option value="{{ $i }}">{{ $i }}</option>
                           @endfor
                         </select>
                         
                      </div>

                      <div class="form-group col-sm-2">
                         
                         <input type="text" name="total_marks[]" id="total_marks" class="form-control" value="" />
                      </div>

                      <div class="form-group col-sm-2 no-padding-left">
                         
                         <input type="text" name="obtain_marks[]" id="obtain_marks" class="form-control" value="" />
                      </div>


                      <div class="form-group col-sm-1 no-padding-left">
                        
                         <select name="grade[]" id="grade" class="form-control">
                           <option value="A+">A+</option>
                           <option value="A">A</option>
                           <option value="B+">B+</option>
                           <option value="B">B</option>
                           <option value="C">C</option>
                           <option value="D">D</option>
                           <option value="E">E</option>
                           <option value="F">F</option>
                         </select>
                      </div>

                      <div class="form-group col-sm-3 no-padding">
                         <input type="text" name="institute[]" id="institute" class="form-control" value="" />
                      </div>

                      <div class="form-group col-sm-12 no-padding">
                          <div class="addMore"></div>
                        </div>

                      </div>

                        <div class="tab-pane" id="experience-tab">

                        <div class="form-group col-sm-12 no-padding text-right">
                          <a href="javascript:void(0)" class="btn btn-xs btn-primary new_row_exper" >ADD</a>
                        </div>

                          


                        <div class="addExpMore">
                            
                            @if(isset($works) && count($works) > 0)

                              @foreach($works as $key => $work)

                                <div class="works_{{$work->id+100}}">
                                  
                                    <div class="form-group col-sm-6 no-padding-left">
                                       <label for="job_title">@lang('admin/employees.job_title_label')</label>
                                       <input type="text" name="job_title[]" id="job_title_1" class="form-control" value="{{$work->job_title}}" />
                                    </div>

                                  <div class="form-group col-sm-6 no-padding">
                                    <label for="company_name">@lang('admin/employees.company_name_label')</label>
                                    <input type="text" name="company_name[]" id="company_name_1" class="form-control" value="{{$work->company_name}}" />
                                  </div>


                                  <div class="form-group col-sm-6 no-padding-left">
                                     <label for="location_country">@lang('admin/employees.location_country_label')</label>
                                     <input type="text" name="location_country[]" id="location_country_1" class="form-control" value="{{$work->country_name}}" />
                                  </div>


                                  <div class="form-group col-sm-6 no-padding">
                                    <label for="location_city">@lang('admin/employees.location_city_label')</label>
                                    <input type="text" name="location_city[]" id="location_city_1" class="form-control" value="{{$work->city_name}}" />
                                  </div>


                                  <div class="form-group col-sm-3 no-padding-left">
                                     <label for="start_month">@lang('admin/employees.time_period_label')</label>
                                     <select name="start_month[]" id="start_month_1" class="form-control">
                                       <option value="">@lang('admin/employees.month')</option>
                                       @foreach($months as $key=>$value)
                                         @if($key == date('m', strtotime($work->start_date)))
                                          <option value="{{$key}}" selected="selected">{{$value}}</option>
                                         @else
                                          <option value="{{$key}}">{{$value}}</option>
                                         @endif
                                       @endforeach
                                     </select>
                                  </div>

                                  <div class="form-group col-sm-3 no-padding-left">
                                     <label for="start_year">&nbsp;</label>
                                     <select name="start_year[]" id="start_year_1" class="form-control">
                                      <option value="">@lang('admin/employees.year')</option>
                                       @for($i=1985; $i<=date('Y'); $i++)
                                         @if($i == date('Y', strtotime($work->start_date)))
                                          <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                                         @else
                                          <option value="{{ $i }}" >{{ $i }}</option>
                                         @endif
                                       @endfor
                                     </select>
                                  </div>

                                  <div class="last_dropdown_{{$work->id+100}}" @if($work->current_status == 1) style="display: none;" @endif>

                                    <div class="form-group col-sm-3 no-padding-left end_month">
                                       <label for="end_month">&nbsp;</label>
                                       <select name="end_month[]" id="end_month_{{$work->id+100}}" class="form-control" @if($work->current_status == 1) style="display: none;" @endif>
                                         <option value="">@lang('admin/employees.month')</option>
                                         @foreach($months as $key=>$value)
                                          @if($key == date('m', strtotime($work->end_date)))
                                            <option value="{{$key}}" selected="selected">{{$value}}</option>
                                           @else
                                            <option value="{{$key}}">{{$value}}</option>
                                           @endif
                                         @endforeach
                                       </select>
                                    </div>

                                    <div class="form-group col-sm-3 no-padding-left end_year">
                                       <label for="start_year">&nbsp;</label>
                                       <select name="end_year[]" id="end_year_{{$work->id+100}}" class="form-control" @if($work->current_status == 1) style="display: none;" @endif>
                                        <option value="">@lang('admin/employees.year')</option>
                                        @for($i=1985; $i<=date('Y'); $i++)
                                          @if($i == date('Y', strtotime($work->end_date)))
                                            <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                                          @else
                                            <option value="{{ $i }}">{{ $i }}</option>
                                          @endif
                                            
                                        @endfor
                                       </select>
                                      
                                    </div>

                                  </div>

                                  <div class="form-group col-sm-10 no-padding-left">
                                     <input type="checkbox" name="curWorkingExp[]" id="curWorkingExp_{{$work->id+100}}" class="regular-checkbox" value="1" @if($work->current_status == 1) checked="checked" @endif onClick="curWork({{$work->id+100}})" />
                                      <label for="curWorkingExp_{{$work->id+100}}" class="curWorkingExp"> @lang('admin/employees.current_checkbox_label') </label>
                                  </div>

                                  <div class="form-group col-sm-2 padding-left">
                                    <label for=""></label>
                                    <button class="btn btn-danger btn-block w_del" data-id="{{$work->id}}" data-row-id="{{$work->id+100}}">DEL</button>
                                  </div>

                                </div>

                            @endforeach

                            @endif

                        </div>

                        <div class="form-group col-sm-6 no-padding-left">
                             <label for="job_title">@lang('admin/employees.job_title_label')</label>
                             <input type="text" name="job_title[]" id="job_title_1" class="form-control" value="" />
                          </div>

                        <div class="form-group col-sm-6 no-padding">
                          <label for="company_name">@lang('admin/employees.company_name_label')</label>
                          <input type="text" name="company_name[]" id="company_name_1" class="form-control" value="" />
                        </div>


                        <div class="form-group col-sm-6 no-padding-left">
                           <label for="location_country">@lang('admin/employees.location_country_label')</label>
                           <input type="text" name="location_country[]" id="location_country_1" class="form-control" value="" />
                        </div>


                        <div class="form-group col-sm-6 no-padding">
                          <label for="location_city">@lang('admin/employees.location_city_label')</label>
                          <input type="text" name="location_city[]" id="location_city_1" class="form-control" value="" />
                        </div>


                        <div class="form-group col-sm-3 no-padding-left">
                           <label for="start_month">@lang('admin/employees.time_period_label')</label>
                           <select name="start_month[]" id="start_month_1" class="form-control">
                             <option value="">@lang('admin/employees.month')</option>
                             @foreach($months as $key=>$value)
                              <option value="{{$key}}">{{$value}}</option>
                             @endforeach
                           </select>
                        </div>

                        <div class="form-group col-sm-3 no-padding-left">
                           <label for="start_year">&nbsp;</label>
                           <select name="start_year[]" id="start_year_1" class="form-control">
                            <option value="">@lang('admin/employees.year')</option>
                             @for($i=1985; $i<=date('Y'); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                           </select>
                        </div>

                        <div class="last_dropdown_1">

                          <div class="form-group col-sm-3 no-padding-left end_month">
                             <label for="end_month">&nbsp;</label>
                             <select name="end_month[]" id="end_month_1" class="form-control">
                               <option value="">@lang('admin/employees.month')</option>
                               @foreach($months as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                               @endforeach
                             </select>
                          </div>

                          <div class="form-group col-sm-3 no-padding-left end_year">
                             <label for="start_year">&nbsp;</label>
                             <select name="end_year[]" id="end_year_1" class="form-control">
                              <option value="">@lang('admin/employees.year')</option>
                              @for($i=1985; $i<=date('Y'); $i++)
                                  <option value="{{ $i }}">{{ $i }}</option>
                              @endfor
                             </select>
                            
                          </div>

                        </div>

                        <div class="form-group col-sm-10 no-padding-left">
                           <input type="checkbox" name="curWorkingExp[]" id="curWorkingExp_1" class="regular-checkbox" value="1" onClick="curWork(1)" />
                            <label for="curWorkingExp_1" class="curWorkingExp"> @lang('admin/employees.current_checkbox_label') </label>
                        </div>




                        </div>


                        <div class="tab-pane" id="salary-tab">

                          <div class="form-group col-sm-12 no-padding">
                            <label for="salary_type">@lang('admin/employees.salary_type_label')</label>
                            <select name="salary_type" id="salary_type" class="form-control" required="required">
                              <option value="">@lang('admin/employees.select_combo')</option>
                              @if(isset($salaries) && count($salaries) > 0)
                                @foreach($salaries as $salary)
                                  @if($salary->id == $employee->salary_type)
                                    <option value="{{ $salary->id }}" selected="selected">{{ $salary->title }}</option>
                                  @else
                                    <option value="{{ $salary->id }}">{{ $salary->title }}</option>
                                  @endif
                                @endforeach
                              @endif
                            </select>
                          </div>

                          <div class="form-group col-sm-4 no-padding-left">
                            <label for="basic_salary">@lang('admin/employees.basic_salary_label')</label>
                            <input type="text" name="basic_salary" id="basic_salary" class="form-control" value="{{ $employee->basic_salary }}" required="required" />
                          </div>

                          <div class="form-group col-sm-4 no-padding-left">
                            <label for="accommodation_allowance">@lang('admin/employees.accommodation_allowance_label')</label>
                            <input type="text" name="accommodation_allowance" id="accommodation_allowance" class="form-control" value="{{ $employee->accomodation_allowance }}" />
                          </div>

                          <div class="form-group col-sm-4 no-padding">
                            <label for="medical_allowance">@lang('admin/employees.medical_allowance_label')</label>
                            <input type="text" name="medical_allowance" id="medical_allowance" class="form-control" value="{{ $employee->medical_allowance }}" />
                          </div>

                          <div class="form-group col-sm-4 no-padding-left">
                            <label for="living_allowance">@lang('admin/employees.living_allowance_label')</label>
                            <input type="text" name="living_allowance" id="living_allowance" class="form-control" value="{{ $employee->house_rent_allowance }}" />
                          </div>

                          <div class="form-group col-sm-4 no-padding-left">
                            <label for="transportation_allowance">@lang('admin/employees.transportation_allowance_label')</label>
                            <input type="text" name="transportation_allowance" id="transportation_allowance" class="form-control" value="{{ $employee->transportation_allowance }}" />
                          </div>

                          <div class="form-group col-sm-4 no-padding">
                            <label for="food_allowance">@lang('admin/employees.food_allowance_label')</label>
                            <input type="text" name="food_allowance" id="food_allowance" class="form-control" value="{{ $employee->food_allowance }}" />
                          </div>

                          <div class="form-group col-sm-4 no-padding-left">
                            <label for="overtime_1">@lang('admin/employees.overtime_1_label') <i> (@1.25) </i></label>
                            <input type="text" name="overtime_1" id="overtime_1" class="form-control" value="{{ $employee->overtime_1 }}" />
                          </div>

                          <div class="form-group col-sm-4 no-padding-left">
                            <label for="overtime_2">@lang('admin/employees.overtime_2_label') <i> (@1.50) </i></label>
                            <input type="text" name="overtime_2" id="overtime_2" class="form-control" value="{{ $employee->overtime_2 }}" />
                          </div>

                          <div class="form-group col-sm-4 no-padding ">
                            <label for="overtime_3">@lang('admin/employees.overtime_3_label') <i> (@2.50) </i></label>
                            <input type="text" name="overtime_3" id="overtime_3" class="form-control" value="{{ $employee->overtime_3 }}" />
                          </div>

                        </div>

                      </div>
                      <div class="form-group">
                        <div class="col-lg-12 no-padding">
                          <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                      </div>
                    </form>
                    
                    
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
        
        
        
      </div>
      
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
        $('#accountForm').bootstrapValidator({
                excluded: [':disabled'],
          })
            .on('status.field.bv', function(e, data) {

                data.element
                .data('bv.messages')
                .find('.help-block[data-bv-for="' + data.field + '"]').hide();

                var $form     = $(e.target),
                    validator = data.bv,
                    $tabPane  = data.element.parents('.tab-pane'),
                    tabId     = $tabPane.attr('id');
                
                if (tabId) {
                    var $icon = $('a[href="#' + tabId + '"][data-toggle="tab"]').parent().find('i');

                    // Add custom class to tab containing the field
                    if (data.status == validator.STATUS_INVALID) {
                        $icon.removeClass('fa-check').addClass('fa-times');
                    } else if (data.status == validator.STATUS_VALID) {
                        var isValidTab = validator.isValidContainer($tabPane);
                        $icon.removeClass('fa-check fa-times')
                             .addClass(isValidTab ? 'fa-check' : 'fa-times');
                    }
                }


            });
    });

    $(document).on('click', '.new_row', function (){

      var html = '';
      var year_html = $("#year").html();

      html += '<div class="form-group col-sm-2 no-padding-left">';
           html += '<input type="text" name="degree[]" id="degree" class="form-control" value=""  />';
        html += '</div>';

        html += '<div class="form-group col-sm-2 no-padding">';
          
           html += '<select name="year[]" id="year" class="form-control">'+year_html+'</select>';
          
        html += '</div>';

        html += '<div class="form-group col-sm-2">';
          
           html += '<input type="text" name="total_marks[]" id="total_marks" class="form-control" value="" />';
        html += '</div>';

        html += '<div class="form-group col-sm-2 no-padding-left">';
          
           html += '<input type="text" name="obtain_marks[]" id="obtain_marks" class="form-control" value="" />';
        html += '</div>';


        html += '<div class="form-group col-sm-1 no-padding-left">';
          
           html += '<select name="grade[]" id="grade" class="form-control">';
             html += '<option value="A+">A+</option>';
             html += '<option value="A">A</option>';
             html += '<option value="B+">B+</option>';
             html += '<option value="B">B</option>';
             html += '<option value="C">C</option>';
             html += '<option value="D">D</option>';
             html += '<option value="E">E</option>';
             html += '<option value="F">F</option>';
           html += '</select>';
        html += '</div>';

        html += '<div class="form-group col-sm-3 no-padding">';
           html += '<input type="text" name="institute[]" id="institute" class="form-control" value="" />';
        html += '</div>';


        $('.addMore').append(html);

        
    });

    var ecount = {{count($works)+1}};
    $(document).on('click', '.new_row_exper', function(){

      var html = '';

      var start_month = $("#start_month_"+ecount).html();
      var start_year = $("#start_year_"+ecount).html();
      var end_month = $("#end_month_"+ecount).html();
      var end_year = $("#end_year_"+ecount).html();

      ecount++;
      
      html += '<div class="form-group col-sm-6 no-padding-left">';
           html += '<label for="job_title">@lang('admin/employees.job_title_label')</label>';
           html += '<input type="text" name="job_title[]" id="job_title_'+ecount+'" class="form-control" value="" />';
        html += '</div>';

      html += '<div class="form-group col-sm-6 no-padding">';
        html += '<label for="company_name_'+ecount+'">@lang('admin/employees.company_name_label')</label>';
        html += '<input type="text" name="company_name[]" id="company_name_'+ecount+'" class="form-control" value="" required="required" />';
      html += '</div>';


      html += '<div class="form-group col-sm-6 no-padding-left">';
         html += '<label for="location_country_'+ecount+'">@lang('admin/employees.location_country_label')</label>';
         html += '<input type="text" name="location_country[]" id="location_country_'+ecount+'" class="form-control" value="" />';
      html += '</div>';


      html += '<div class="form-group col-sm-6 no-padding">';
        html += '<label for="location_city_'+ecount+'">@lang('admin/employees.location_city_label')</label>';
        html += '<input type="text" name="location_city[]" id="location_city_'+ecount+'" class="form-control" value="" />';
      html += '</div>';


      html += '<div class="form-group col-sm-3 no-padding-left">';
         html += '<label for="start_month_'+ecount+'">@lang('admin/employees.time_period_label')</label>';
         html += '<select name="start_month[]" id="start_month_'+ecount+'" class="form-control" >'+start_month+'</select>';
      html += '</div>';

      html += '<div class="form-group col-sm-3 no-padding-left">';
         html += '<label for="start_year_'+ecount+'">&nbsp;</label>';
         html += '<select name="start_year[]" id="start_year_'+ecount+'" class="form-control">'+start_year+'</select>';
      html += '</div>';

      html += '<div class="last_dropdown_'+ecount+'">';

      html += '<div class="form-group col-sm-3 no-padding-left">';
         html += '<label for="end_month_'+ecount+'">&nbsp;</label>';
         html += '<select name="end_month[]" id="end_month_'+ecount+'" class="form-control">'+end_month+'</select>';
      html += '</div>';

      html += '<div class="form-group col-sm-3 no-padding-left">';
         html += '<label for="start_year_'+ecount+'">&nbsp;</label>';
         html += '<select name="end_year[]" id="end_year_'+ecount+'" class="form-control" >'+end_year+'</select>';
      html += '</div>';

      html += '</div>';

      html += '<div class="form-group col-sm-12 no-padding-left">';
         html += '<input type="checkbox" name="curWorkingExp[]" id="curWorkingExp_'+ecount+'" value="1" class="regular-checkbox" onClick="curWork('+ecount+')" />';
          html += '<label for="curWorkingExp_'+ecount+'" class="curWorkingExp"> @lang('admin/employees.current_checkbox_label') </label>';
      html += '</div>';

      $('.addExpMore').append(html);

    });

    $('.datepicker').dateDropper();

    function curWork(i){

       var ckbox = $('#curWorkingExp_'+i);
       if(ckbox.is(':checked')){
        $('.last_dropdown_'+i).css('display', 'none');
        $('#end_month_'+i).prop('disabled', true);
        $('#end_year_'+i).prop('disabled', true);
        $('#end_month_'+i).css('display', 'none');
        $('#end_year_'+i).css('display', 'none');
       }else{
        $('.last_dropdown_'+i).css('display', 'block');
        $('#end_month_'+i).prop('disabled', false);
        $('#end_year_'+i).prop('disabled', false);
        $('#end_month_'+i).css('display', 'block');
        $('#end_year_'+i).css('display', 'block');
       }
    }

    $(document).ready(function(){

      $(".delete_row").click(function(){

        var conf = confirm('Are you sure to delete this record?');
        if(conf)
        {
          var q_id = $(this).attr('data-id');
          var data_row_id = $(this).attr('data-row-id');

          $(".q_row_"+data_row_id+" input, .q_row_"+data_row_id+" select").prop('disabled', true);

          var url = '{{ url('admin/employees/index') }}';

          $.ajax({
              method: 'POST', // Type of response and matches what we said in the route
              url: url, // This is the url we gave in the route
              data: {'id' : q_id, 'action' : 'q_remove', "_token":"{{ csrf_token() }}"}, // a JSON object to send back
              success: function(response){ // What to do if we succeed
                  $(".q_row_"+data_row_id).remove();
              },
              error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                  console.log(JSON.stringify(jqXHR));
                  console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
              }
          });
          
        }

        return false;
      });


      $(".w_del").click(function(){

        var conf = confirm('Are you sure to delete this record?');
        if(conf)
        {
          var w_id = $(this).attr('data-id');
          var data_row_id = $(this).attr('data-row-id');
          
         
          $(".works_"+data_row_id+" input, .works_"+data_row_id+" select").prop('disabled', true);

          var url = '{{ url('admin/employees/index') }}';

          $.ajax({
              method: 'POST', // Type of response and matches what we said in the route
              url: url, // This is the url we gave in the route
              data: {'id' : w_id, 'action' : 'w_remove', "_token":"{{ csrf_token() }}"}, // a JSON object to send back
              success: function(response){ // What to do if we succeed
                  $(".works_"+data_row_id).remove();
              },
              error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                  console.log(JSON.stringify(jqXHR));
                  console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
              }
          });
          
        }

        return false;
      });

    });
    </script>
@endsection