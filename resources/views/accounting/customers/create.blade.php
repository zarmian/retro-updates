@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/customers.create_customer_heading')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('accounting/customers') }}">@lang('admin/customers.manage_heading')</a>  / 
        <a href="#" class="active">@lang('admin/customers.create_customer_heading')</a>
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

         <form data-toggle="validator" role="form" action="{{ url('accounting/customers/save') }}" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="form_container">

          
          {{-- Left From Colum --}}
          <div class="col-sm-9 col-md-9 col-lg-9 col-xs-12 col-sm-offset-2">
            <div class="top_content">
              <h3>@lang('admin/users.person_detail_heading')</h3>
              <p>@lang('admin/users.field_employee_text')</p>
            </div>

            <div class="form_container">

              <div class="col-md-2 col-sm-2 col-lg-2 col-xs-2 form-group">
                  <label for="code" class="input_label">@lang('admin/customers.code_label')</label>
                  <input type="text" name="code" id="code" class="form-control1" placeholder="@lang('admin/customers.code_label')*" required="required" value="{{ $code }}" />
                </div>

                <div class="col-md-5 col-sm-5 col-lg-5 col-xs-5 form-group">
                  <label for="first_name" class="input_label">@lang('admin/users.name_label')</label>
                  <input type="text" name="first_name" id="first_name" class="form-control1" placeholder="@lang('admin/users.first_name_label')*" required="required" value="{{ old('first_name') }}" />
                </div>

                <div class="col-md-5 col-sm-5 col-lg-5 col-xs-5 form-group">
                  <label for="last_name" class="input_label">&nbsp;</label>
                  <input type="text"  name="last_name" id="last_name" class="form-control1" placeholder="@lang('admin/users.last_name_label')*" required="required" value="{{ old('last_name') }}" />
                </div>

                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                  <label for="company" class="input_label">@lang('admin/customers.company_label')*</label>
                  <input type="text" name="company" id="company" class="form-control1" value="{{ old('company') }}" placeholder="@lang('admin/customers.company_label')" />
                </div>

                <div class="col-md-8 col-sm-8 col-lg-8 col-xs-8 form-group">
                  <label for="email" class="input_label">@lang('admin/users.email_label')*</label>
                  <input type="email" name="email" id="email" class="form-control1" value="{{ old('email') }}" required="required" data-bv-emailaddress-message="The input is not a valid email address" placeholder="@lang('admin/users.email_label')*" />
                </div>


                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                  <label for="phone" class="input_label">@lang('admin/users.phone_label')*</label>
                  <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required="required" class="form-control1" placeholder="@lang('admin/users.phone_label')*">
                </div>

                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                    <label for="mobile" class="input_label">@lang('admin/users.cell_label')</label>
                    <input type="text" name="mobile" id="mobile" class="form-control1" value="{{ old('mobile') }}" placeholder="@lang('admin/users.cell_label')" />
                </div>


                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                  <label for="fax" class="input_label">@lang('admin/users.fax_label')</label>
                  <input type="text" name="fax" id="fax" value="{{ old('fax') }}" class="form-control1" placeholder="@lang('admin/users.fax_label')">
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="present_address" class="input_label">@lang('admin/users.present_address_label')*</label>
                  <input type="text" name="present_address" id="present_address" value="{{ old('present_address') }}" required="required" class="form-control1" placeholder="@lang('admin/users.present_address_label')">
                </div>


                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="permanent_address" class="input_label">@lang('admin/users.permanant_address_label')</label>
                  <input type="text" name="permanent_address" id="permanent_address" value="{{ old('permanent_address') }}" class="form-control1" placeholder="@lang('admin/users.permanant_address_label')">
                </div>


                
                <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                  <label for="nationality" class="input_label" required="required">@lang('admin/users.nationality_label')</label>
                  <select name="nationality" id="nationality" class="form-control1" required="required">
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

                <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                  <label for="state_label" class="input_label">@lang('admin/users.state_label')</label>
                  <input type="text" name="state" id="state" value="{{ old('state') }}"  class="form-control1" placeholder="@lang('admin/users.state_label')">
                </div>


                <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                  <label for="city" class="input_label">@lang('admin/users.city_label')</label>
                  <input type="text" name="city" id="city" value="{{ old('city') }}" class="form-control1" placeholder="@lang('admin/users.city_label')">
                </div>


                <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                  <label for="postal_code" class="input_label">@lang('admin/users.postal_label')</label>
                  <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}"  class="form-control1" placeholder="@lang('admin/users.postal_label')">
                </div>



                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <textarea name="reference" id="reference" cols="30" rows="10" class="form-control2" placeholder="@lang('admin/users.reference_label')">{{ old('reference') }}</textarea>
                </div>

                


              </div>
              
            </div>


            {{-- Right Form Column --}}

            

            <div class="col-sm-10 col-sm-offset-2">
              <div class="col-sm-2 col-lg-2 col-md-2 col-xs-12">
              <label for="" class="input_label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
              <button type="submit" name="submitButton" class="btn btn-primary btn-block new-btn">@lang('admin/users.submit_button')</button>
              {{-- <button type="submit" class="btn btn-primary btn-step mbtn btn-block" id="next"></button> --}}
            </div>
            </div>
    
            </div>


        </form>


      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function (){
      $('form[data-toggle="validator"]').bootstrapValidator('revalidateField');
    });
  </script>
@endsection