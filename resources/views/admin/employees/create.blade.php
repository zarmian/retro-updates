@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/employees.create')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('') }}">@lang('admin/dashboard.dashboard-heading')</a>  /
        <a href="{{ url('/employees') }}">@lang('admin/employees.manage')</a>  /
        <a href="#" class="active">@lang('admin/employees.create')</a>
      </div>
    </div>
  </div>
</section>
@endsection
@section('content')


<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">


      <div class="col-sm-12 col-md-12 col-lg-12">

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
      <form id="accountForm" method="post" class="registration-form" action="{{ url('/employees/store') }}" style="margin-top: 20px;" enctype="multipart/form-data">
      

      <fieldset>
  
        <div class="form_container">

          
          {{-- Left From Colum --}}
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
            <div class="top_content">
              <h3>@lang('admin/employees.person_detail_heading')</h3>
              <p>@lang('admin/employees.field_employee_text')</p>
            </div>

            <div class="form_container">

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="first_name" class="input_label">@lang('admin/employees.employees_name_label')</label>
                <input type="text" name="first_name" id="first_name" class="form-control1" placeholder="@lang('admin/employees.first_name_label')*" required="required" value="{{ old('first_name') }}" />
              </div>
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="last_name" class="input_label">&nbsp;</label>
                <input type="text"  name="last_name" id="last_name" class="form-control1" placeholder="@lang('admin/employees.last_name_label')*" required="required" value="{{ old('last_name') }}" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="gender" class="input_label">@lang('admin/employees.gender_label')</label>
                <div class="btn-group btn-group-justified" data-toggle="buttons">

                @if(isset($genders) && count($genders) > 0)
                  @foreach($genders as $gender)
                    <label class="btn btn-default btn-gender @if($gender->title == "Male") active @endif">
                        <input type="radio" name="gender" id="gender" autocomplete="off" @if($gender->title == "Male") checked="checked" @endif value="{{ $gender->id }}" /> 
                        <span>{{$gender->title}}</span> <i class="fa @if($gender->title == "Male") fa-male @else fa-female @endif" aria-hidden="true"></i>
                    </label>
                  @endforeach
                @endif

                
              </div>
              </div>
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <div class="col-sm-12 text-left no-padding"><label for="" class="input_label">@lang('admin/employees.dob_label')</label></div>
                <div class="col-sm-3 col-xs-3 col-padding">
                  <input type="text" name="dob_day" id="dob_day" value="{{ old('dob_day') }}" class="datepicker form-control1 text-padding-5" required="required" data-format="d" data-fx="false" data-fx-mobile="true" placeholder="DD" />
                </div>

                <div class="col-sm-3 col-xs-3 col-padding">
                  <input type="text" name="dob_month" id="dob_month" value="{{ old('dob_month') }}" class="datepicker form-control1 text-padding-5" data-format="m" placeholder="MM" required="required" />
                </div>

                <div class="col-sm-6 col-xs-6 col-padding">
                  <input type="text" name="dob_year" id="dob_year" value="{{ old('dob_year') }}" class="form-control1 datepicker" data-format="Y" placeholder="YYYY" required="required" data-fx="false" data-fx-mobile="true" />
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="national_id" class="input_label">@lang('admin/employees.national_id_label')</label>
                <input type="text" name="national_id" id="national_id" class="form-control1" value="{{ old('national_id') }}"  placeholder="@lang('admin/employees.national_id_label')">
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="nationality" class="input_label">@lang('admin/employees.nationality_label')</label>
                <select name="nationality" id="nationality" class="chosen form-control1" required="required" style="width: 100%">
                @if(isset($countries) && count($countries) > 0)
                  @foreach($countries as $country)
                    @if(old('nationality') == $country->id)
                      <option value="{{ $country->id }}" selected="selected">{{ $country->country_name }}</option>
                    @else
                      <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                    @endif
                    
                  @endforeach
                @endif
                  
                </select>
              </div>


              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="fathers_name" class="input_label">@lang('admin/employees.fathers_name_label')</label>
                <input type="text" name="fathers_name" id="fathers_name" class="form-control1" placeholder="@lang('admin/employees.fathers_name_label')" value="{{ old('fathers_name') }}" />
              </div>
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="mothers_name" class="input_label">@lang('admin/employees.mothers_name_label')</label>
                <input type="text" class="form-control1" name="mothers_name" id="mothers_name" placeholder="@lang('admin/employees.mothers_name_label')" value="{{ old('mothers_name') }}"  />
              </div>



              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="phone" class="input_label">@lang('admin/employees.email_label')*</label>
                <input type="email" name="email" id="email" class="form-control1" value="{{ old('email') }}" required="required" data-bv-emailaddress-message="The input is not a valid email address" placeholder="@lang('admin/employees.email_label')*" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="" class="input_label">@lang('admin/employees.phone_label')*</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required="required" class="form-control1" placeholder="@lang('admin/employees.phone_label')*">
              </div>


              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <input type="text" name="present_address" id="present_address" class="form-control1" placeholder="@lang('admin/employees.present_address_label')" value="{{ old('present_address') }}"  />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <input type="text" name="permanant_address" id="permanant_address" class="form-control1" placeholder="@lang('admin/employees.permanant_address_label')" value="{{ old('permanant_address') }}" />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
              <textarea name="reference" id="reference" cols="30" rows="10" class="form-control2" placeholder="@lang('admin/employees.reference_label')">{{ old('reference') }}</textarea>
              </div>

              {{-- <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                <label class="btn btn-block btn-default btn-avatar">
                  @lang('admin/employees.avatar_label')&hellip; <input type="file" name="avatar" id="avatar" style="display: none;">
                </label>
              </div> --}}


            </div>
            
          </div>


          {{-- Right Form Column --}}

          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">

            <div class="top_content">
              <h3>@lang('admin/employees.employee_credentials')</h3>
              <p>@lang('admin/employees.field_employee_text')</p>
            </div>

            <div class="form_container">

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="username" class="input_label">@lang('admin/employees.employee_login_label')</label>
                <input type="text" name="username" id="username" class="form-control1" placeholder="@lang('admin/employees.username_label')*" value="{{ old('username') }}" required="required">
              </div>
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="" class="input_label">&nbsp;</label>
                <input type="text" name="employee_code" id="employee_code" class="form-control1" placeholder="@lang('admin/employees.employee_code_label')" value="{{ $code }}" readonly="readonly" required="required" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <input type="password" name="password" id="password" class="form-control1" placeholder="@lang('admin/employees.password_label')" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required="required" data-bv-identical-field="password_confirmation" />
              </div>
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control1" value="" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" data-bv-identical-field="password" data-bv-identical="true" placeholder="@lang('admin/employees.c_password_label')" />
              </div>

              <div class="col-sm-12 input_label" style="margin-bottom: 10px;"><b>@lang('admin/common.password_note')</b></div>
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">

                <div class="col-sm-12 text-left no-padding"><label for="joining_day" class="input_label">@lang('admin/employees.joining_date_label')</label></div>

                <div class="col-sm-3 col-padding">
                  <input type="text" name="joining_day" id="joining_day" class="datepicker form-control1 text-padding-5" required="required" data-format="d" data-fx="false" data-fx-mobile="true" placeholder="DD" value="{{ old('joining_day') }}" />
                </div>

                <div class="col-sm-3 col-padding ">
                  <input type="text" name="joining_month" id="joining_month" class="datepicker form-control1 text-padding-5" required="required" data-format="m" data-fx="false" data-fx-mobile="true" placeholder="MM" value="{{ old('joining_month') }}" />
                </div>

                <div class="col-sm-6 col-padding">
                  <input type="text" name="joining_year" id="joining_year"  placeholder="YYYY" class="datepicker form-control1 text-padding-5" required="required" data-format="Y" data-fx="false" data-fx-mobile="true" value="{{ old('joining_year') }}" />
                </div>
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group no-padding-right">
                <label for="" class="input_label">@lang('admin/employees.role_label')*</label>
                <select name="group" id="group" class="form-control1" required="required">
                  @if(isset($roles) && count($roles) > 0)
                  <option value="">@lang('admin/employees.select_option') </option>
                    @foreach($roles as $role)
                      @if(old('group') == $role->id)
                        <option value="{{ $role->id }}" selected="selected">{{ $role->title }}</option>
                      @else
                        <option value="{{ $role->id }}">{{ $role->title }}</option>
                      @endif
                    @endforeach
                  @endif
                </select>
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                <label for="" class="input_label">@lang('admin/employees.status_label')*</label>
                <select name="status" id="status" class="form-control1" required="required">
                  <option value="1">@lang('admin/employees.active_option')</option>
                  <option value="0">@lang('admin/employees.inactive_option')</option>
                </select>
              </div>


              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="department_id" class="input_label">@lang('admin/employees.department_label')*</label>
                <select name="department_id" id="department_id" class="form-control1" required="required">
                <option value="">@lang('admin/employees.select_option')</option>
                  @if(isset($departments) && count($departments) > 0)
                    @foreach($departments as $department)
                      @if($department->id == old('department_id'))
                        <option value="{{ $department->id }}" selected="selected">{{ $department->title }}</option>
                      @else
                        <option value="{{ $department->id }}">{{ $department->title }}</option>
                      @endif
                    @endforeach
                  @endif
                </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="designation_id" class="input_label">@lang('admin/employees.designation_label')*</label>
                <select name="designation_id" id="designation_id" class="form-control1" required="required">
                <option value="">@lang('admin/employees.select_option') </option>
                @if(isset($designations) && count($designations) > 0)
                  @foreach($designations as $designation)
                    @if($designation->id == old('designation_id'))
                      <option value="{{ $designation->id }}" selected="selected">{{ $designation->title }}</option>
                    @else
                      <option value="{{ $designation->id }}">{{ $designation->title }}</option>
                    @endif
                  @endforeach
                @endif
              </select>
              </div>

              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                <label for="shift_id" class="input_label">@lang('admin/employees.shift_label')*</label>
                <select name="shift_id" id="shift_id" class="form-control1" required="required">
                <option value="">@lang('admin/employees.select_option')</option>
                @if(isset($shifts) && count($shifts) > 0)
                  @foreach($shifts as $shift)
                    @if($shift->id == old('shift_id'))
                      <option value="{{ $shift->id }}" selected="selected">{{ $shift->title }}</option>
                    @else
                      <option value="{{ $shift->id }}">{{ $shift->title }}</option>
                    @endif
                  @endforeach
                @endif
              </select>
              </div>

              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                <label for="employee_type" class="input_label">@lang('admin/employees.employee_type_label')</label>
                <select name="employee_type" id="employee_type" class="form-control1" required="required">
                <option value="">@lang('admin/employees.select_option')</option>
                @if(isset($types) && count($types) > 0)
                  @foreach($types as $type)
                    @if($type->id == old('employee_type'))
                      <option value="{{ $type->id }}" selected="selected">{{ $type->title }}</option>
                    @else
                      <option value="{{ $type->id }}">{{ $type->title }}</option>
                    @endif
                  @endforeach
                @endif
              </select>
              </div>


              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                <label for="allowed_leaves" class="input_label">@lang('admin/employees.employee_allowed_leaves')</label>
                <select name="allowed_leaves" id="allowed_leaves" class="form-control1" required="required">
                <option value="">@lang('admin/employees.select_option')</option>
                @if(isset($types) && count($types) > 0)
                  @for($i=1; $i<=10; $i++)
                    @if($type->id == old('allowed_leaves'))
                      <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                    @else
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endif
                  @endfor
                @endif
              </select>
              </div>

              <div class="col-sm-12 top_content form_container">
                <h3>@lang('admin/employees.employee_account_heading')</h3>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="salary_type" class="input_label">@lang('admin/employees.salary_type_label')</label>
                <select name="salary_type" id="salary_type" class="form-control1" required="required">
                  <option value="">@lang('admin/employees.select_option') </option>
                  @if(isset($salaries) && count($salaries) > 0)
                    @foreach($salaries as $salary)
                      @if(old('salary_type') == $salary->id)
                        <option value="{{ $salary->id }}" selected="selected">{{ $salary->title }}</option> 
                      @else
                        <option value="{{ $salary->id }}">{{ $salary->title }}</option>
                      @endif
                      
                    @endforeach
                  @endif
                </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="basic_salary" class="input_label">@lang('admin/employees.basic_salary_label')</label>
                <input type="text" name="basic_salary" id="basic_salary" class="form-control1" value="{{ old('basic_salary') }}" required="required" placeholder="15000.00" />
              </div>


              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group col-padding-right">
                <label for="accommodation_allowance" class="input_label">@lang('admin/employees.allowance')</label>
                <input type="text" name="accommodation_allowance" id="accommodation_allowance" class="form-control1" value="{{ old('accommodation_allowance') }}" placeholder="@lang('admin/employees.accomodation')" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group col-padding">
                <label for="medical_allowance" class="input_label">&nbsp;</label>
                <input type="text" name="medical_allowance" id="medical_allowance" class="form-control1" placeholder="@lang('admin/employees.medical')" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group col-padding">
                <label for="transportation_allowance" class="input_label">&nbsp;</label>
                <input type="text" name="transportation_allowance" id="transportation_allowance" class="form-control1" value="{{ old('transportation_allowance') }}" placeholder="@lang('admin/employees.transport')" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group col-padding-left">
                <label for="food_allowance" class="input_label">&nbsp;</label>
                <input type="text" class="form-control1" name="food_allowance" id="food_allowance"  value="{{ old('food_allowance') }}"  placeholder="@lang('admin/employees.food_allowance')"" />
              </div>


              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group col-padding-right">
                <label for="overtime_1" class="input_label">@lang('admin/employees.overtime')</label>
                <input type="text" name="overtime_1" id="overtime_1" class="form-control1" value="{{ old('overtime_1') }}" placeholder="1.25%" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group col-padding">
                <label for="" class="input_label">&nbsp;</label>
                <input type="text" name="overtime_2" id="overtime_2" class="form-control1" value="{{ old('overtime_2') }}" placeholder="1.50%" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group col-padding">
                <label for="" class="input_label">&nbsp;</label>
                <input type="text" name="overtime_3" id="overtime_3" class="form-control1" value="{{ old('overtime_3') }}" placeholder="2.50%" />
              </div>


            </div>

          </div>

          <div class="col-sm-12">
            <div class="col-sm-2 col-lg-2 col-md-2 col-xs-12">
            <label for="" class="input_label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <button type="button" class="btn btn-primary btn-step mbtn btn-block" id="next">@lang('admin/employees.submit_next_button')</button>
          </div>
          </div>
  
          </div>
        </fieldset>

        <fieldset>
          <div class="form_container">

          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
            <div class="top_content">
              <h3>@lang('admin/employees.employee_eduction_heading')</h3>
              <p>@lang('admin/employees.field_employee_text')</p>
            </div>

            <div class="form_container">

              <div class="eduction-container">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">
                <label for="degree">@lang('admin/employees.degree_label')</label>
                <input type="text" name="degree[]" id="degree" class="form-control1" placeholder="@lang('admin/employees.degree_label')" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">
                <label for="year">@lang('admin/employees.year_label')</label>
                <input type="text" name="year[]" id="year" class="form-control1 datepicker" data-format="Y" placeholder="YYYY" data-fx="false" data-fx-mobile="true" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">
                <label for="grade">@lang('admin/employees.grade_label')</label>
                <select name="grade[]" id="grade" class="form-control1">
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

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">
                <label for="total_marks">@lang('admin/employees.total_marks_label')</label>
                <input type="text" name="total_marks[]" id="total_marks" placeholder="1100" class="form-control1" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">
                <label for="obtain_marks">@lang('admin/employees.obtain_marks_label')</label>
                <input type="text" class="form-control1" name="obtain_marks[]" id="obtain_marks" class="form-control" value="" placeholder="950">
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">
                <label for="institute">@lang('admin/employees.institute_label')</label>
                <input type="text" name="institute[]" id="institute" class="form-control1" placeholder="@lang('admin/employees.institute_label')" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">
                <label for="">@lang('admin/employees.institute_country_label')</label>


                <select name="institute_country[]" id="institute_country" class="chosen form-control1" style="width: 100%;">
                @if(isset($countries) && count($countries) > 0)
                  <option value="">@lang('admin/employees.select_option')</option>
                  @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                  @endforeach
                @endif
                </select>
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding add-more-col">
                <button type="button" class="btn btn-primary mbtn add-more-btn btn-block">@lang('admin/employees.add_more_button')</button>
              </div>

              <div class="col-md-12"></div>

              </div>

              

              <div class="add_more_education"></div>

            </div>


          </div>


          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
            <div class="top_content">
              <h3>@lang('admin/employees.job_experience_heading')</h3>
              <p>@lang('admin/employees.field_employee_text')</p>
            </div>

            <div class="form_container">

              <div class="experience-container">

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">
                <label for="job_title_1">@lang('admin/employees.job_title_label')</label>
                <input type="text" name="job_title[]" id="job_title_1" class="form-control1" placeholder="@lang('admin/employees.job_title_label')" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">
                <label for="company_name_1">@lang('admin/employees.company_name_label')</label>
                <input type="text" name="company_name[]" id="company_name_1" class="form-control1" placeholder="@lang('admin/employees.company_name_label')" />
              </div>


              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">
                <label for="location_country_1">@lang('admin/employees.location_country_label')</label>
                <select name="location_country[]" id="location_country_1" class="form-control1 chosen" style="width: 100%;">
                    @if(isset($countries) && count($countries) > 0)
                      @foreach($countries as $country)
                          <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                      @endforeach
                    @endif
                    </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">
                <label for="location_city_1">@lang('admin/employees.location_city_label')</label>
                <input type="text" name="location_city[]" id="location_city_1" class="form-control1" placeholder="@lang('admin/employees.location_city_label')" />
              </div>

              <div class="col-sm-12 col-md-12 col-lg-12 col-xs 12 col-padding"><i>@lang('admin/employees.current_working')</i></div>


              <div class="col-md-2 col-sm-2 col-lg-2 col-xs-6 form-group col-padding">
                  <label for="start_month_1">@lang('admin/employees.join_date_label') </label>
                  <input type="text" name="start_month[]" id="start_month_1" value="" class="datepicker form-control1 text-padding-5" data-format="m" placeholder="MM" />

                </div>

                <div class="col-md-2 col-sm-2 col-lg-2 col-xs-6 form-group col-padding">
                  <label for="start_year_1">&nbsp; </label>

                  <input type="text" name="start_year[]" id="start_year_1" class="form-control1 datepicker" data-format="Y" placeholder="YYYY" data-fx="false" data-fx-mobile="true" />
                </div>




              <div class="col-md-2 col-sm-2 col-lg-2 col-xs-6 form-group col-padding">
                <label for="end_month_1">@lang('admin/employees.to_date_label')</label>
               <input type="text" name="end_month[]" id="end_month_1" class="datepicker form-control1 text-padding-5" data-format="m" placeholder="MM" data-init-set="false" />
              </div>

              <div class="col-md-2 col-sm-2 col-lg-2 col-xs-6 form-group col-padding">
                <label for="end_year_1">&nbsp;</label>

               <input type="text" name="end_year[]" id="end_year_1" class="form-control1 datepicker" data-format="Y" placeholder="YYYY" data-fx="false" data-fx-mobile="true" data-init-set="false" />

              </div>


              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding add-more-col">
                
                <button type="button" class="btn btn-primary mbtn add-more-btn-exp btn-block">@lang('admin/employees.add_more_button')</button>
              </div>


              </div>

              

              <div class="add_more_experience"></div>

            </div>

          </div>

          <div class="col-sm-12 no-padding">
            <div class="col-sm-2 col-lg-2 col-md-2 col-xs-12">
            <label for="" class="input_label">&nbsp;</label>
            <button type="submit" name="submitButton" id="submitButton" class="btn btn-primary mbtn btn-block">@lang('admin/employees.submit_button')</button>
          </div>
          </div>
            
          </div>
        </fieldset>
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        </form>

      </div>
      
      
      
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script type="text/javascript">

    $(document).ready(function() {

      $('.registration-form fieldset:first-child').fadeIn('slow').show();

      $("#next").click(function () {
        $('#accountForm').bootstrapValidator('validate');
      });

      ValidateIt();
    });

    function ValidateIt() {
        $('#accountForm').bootstrapValidator({
                excluded: [':disabled'],
          }).on('status.field.bv', function(e, data) {

                data.element
                .data('bv.messages')
                .find('.help-block[data-bv-for="' + data.field + '"]').hide();

            }).on('success.form.bv', function (e) {

              $('input[type="submit"]').prop('disabled', false);
              var parent_fieldset = $('.registration-form .btn-step').parents('fieldset');
              var next_step = true;

              if (next_step) {
                  parent_fieldset.fadeOut(400, function () {
                      $(this).next().fadeIn();
                  });
                  $("#submitButton").attr('disabled', false);
              }
            });
      }


    $(document).on('click', '.add-more-btn', function (){

      var html = '';
      var year_html = $("#year").html();
      var institute_country = $('#institute_country').html();

      var btn = $(this);
      btn.closest('.add-more-col').find('button').html('REMOVE').attr('data-id', 'remove').removeClass('btn-primary add-more-btn').addClass('btn-danger remove-more-btn');
        
        html += '<div class="eduction-container">';
        html += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">';
          html += '<label for="degree">@lang('admin/employees.degree_label')</label>';
          html += '<input type="text" name="degree[]" id="degree" class="form-control1" placeholder="@lang('admin/employees.degree_label')" />';
        html += '</div>';

        html += '<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">';
          html += '<label for="year">@lang('admin/employees.year_label')</label>';
          html += '<input type="text" name="year[]" id="year" class="form-control1 datepicker" data-format="Y" placeholder="YYYY" data-fx="false" data-fx-mobile="true"  />';
        html += '</div>';

        html += '<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">';
          html += '<label for="grade">Grade</label>';
          html += '<select name="grade[]" id="grade" class="form-control1">';
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

        html += '<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">';
          html += '<label for="total_marks">@lang('admin/employees.total_marks_label')</label>';
          html += '<input type="text" name="total_marks[]" id="total_marks" placeholder="1100" class="form-control1" />';
        html += '</div>';

        html += '<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">';
          html += '<label for="obtain_marks">@lang('admin/employees.obtain_marks_label')</label>';
          html += '<input type="text" class="form-control1" name="obtain_marks[]" id="obtain_marks" class="form-control" value="" placeholder="950" />';
        html += '</div>';

        html += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">';
          html += '<label for="institute">@lang('admin/employees.institute_label')</label>';
          html += '<input type="text" name="institute[]" id="institute" class="form-control1" placeholder="@lang('admin/employees.institute_label')" />';
        html += '</div>';

        html += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">';
          html += '<label for="">@lang('admin/employees.institute_country_label')</label>';
          html += '<select name="institute_country[]" id="institute_country" class="form-control1 chosen" style="width: 100%;">'+institute_country+'</select>';
        html += '</div>';

        html += '<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding add-more-col">';
          html += '<button type="button" class="btn btn-primary mbtn add-more-btn btn-block">@lang('admin/employees.add_more_button')</button>';
        html += '</div>';
        html += '<div class="col-md-12"></div>';
        html += '</div>';


        $('.add_more_education').append(html);
        $(".chosen").select2();
        $('.datepicker').dateDropper();
        
    });


    $(document).on('click', '.add-more-btn-exp', function (){

      var html = '';
      var year_html = $("#year").html();
      var institute_country = $('#institute_country').html();

      var btn = $(this);
      btn.closest('.add-more-col').find('button').html('REMOVE').attr('data-id', 'remove').removeClass('btn-primary add-more-btn-exp').addClass('btn-danger remove-more-btn-exp');
        
        html += '<div class="experience-container">';

          html += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">';
            html += '<label for="job_title_1">@lang('admin/employees.job_title_label')</label>';
            html += '<input type="text" name="job_title[]" id="job_title_1" class="form-control1" placeholder="@lang('admin/employees.job_title_label')" />';
          html += '</div>';

          html += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">';
            html += '<label for="company_name_1">@lang('admin/employees.company_name_label')</label>';
            html += '<input type="text" name="company_name[]" id="company_name_1" class="form-control1" placeholder="@lang('admin/employees.company_name_label')" />';
          html += '</div>';


          html += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">';
            html += '<label for="location_country_1">@lang('admin/employees.location_country_label')</label>';
            html += '<select name="location_country[]" id="location_country_1" class="form-control1 chosen" style="width: 100%;">';
            @if(isset($countries) && count($countries) > 0)
             html += '<option value="">@lang('admin/employees.select_option')</option>';
            @foreach($countries as $country)
                 html += '<option value="{{ $country->id }}">{{ $country->country_name }}</option>';
            @endforeach
          @endif
          html += '</select>';
          html += '</div>';

          html += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">';
            html += '<label for="location_city_1">@lang('admin/employees.location_city_label')</label>';
            html += '<input type="text" name="location_city[]" id="location_city_1" class="form-control1" placeholder="@lang('admin/employees.location_city_label')" />';
          html += '</div>';

          html += '<div class="col-sm-12 col-md-12 col-lg-12 col-xs 12 col-padding"><i>@lang('admin/employees.current_working')</i></div>';

          html += '<div class="col-md-2 col-sm-2 col-lg-2 col-xs-4 form-group col-padding">';
            html += '<label for="start_month_1">@lang('admin/employees.join_date_label')</label>';

            html += '<input type="text" name="start_month[]" id="start_month_1" value="" class="datepicker form-control1 text-padding-5" data-format="m" placeholder="MM" />';

          html += '</div>';

          html += '<div class="col-md-2 col-sm-2 col-lg-2 col-xs-4 form-group col-padding">';
            html += '<label for="start_year_1">&nbsp;</label>';

            html += '<input type="text" name="start_year[]" id="start_year_1" class="form-control1 datepicker" data-format="Y" placeholder="YYYY" data-fx="false" data-fx-mobile="true" />';

            
          html += '</div>';


          html += '<div class="col-md-2 col-sm-2 col-lg-2 col-xs-4 form-group col-padding">';
            html += '<label for="end_month_1">@lang('admin/employees.to_date_label')</label>';

            html += '<input type="text" name="end_month[]" id="end_month_1" value="" class="datepicker form-control1 text-padding-5" data-format="m" placeholder="MM" data-init-set="false" />';

          
          html += '</div>';

          html += '<div class="col-md-2 col-sm-2 col-lg-2 col-xs-4 form-group col-padding">';
            html += '<label for="end_year_1">&nbsp;</label>';

            html += '<input type="text" name="end_year[]" id="end_year_1" class="form-control1 datepicker" data-format="Y" placeholder="YYYY" data-fx="false" data-fx-mobile="true" data-init-set="false" />';
          html += '</div>';

          
          
          html += '<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding add-more-col">';
            html += '<button type="button" class="btn btn-primary mbtn add-more-btn-exp btn-block">ADD MORE</button>';
          html += '</div>';


          html += '</div>';


        $('.add_more_experience').append(html);
        $(".chosen").select2();
        $('.datepicker').dateDropper();

        
    });

    $(document).on('click', '.remove-more-btn', function (){
      var btn = $(this);
      btn.closest('.eduction-container').remove();
    });

    $(document).on('click', '.remove-more-btn-exp', function (){
      var btn = $(this);
      btn.closest('.experience-container').remove();
    });

    $('.datepicker').dateDropper();

    </script>

    <script type="text/javascript">
      $(".chosen").select2();
    </script>
@endsection