@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/timepicki.css') }}"/>
@endsection

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>Add New Product to Truck</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('/accounting/trucks') }}">Truck</a>  / 
        <a href="#" class="active">Add New Product to Truck</a>
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
          
        @if(isset($errors) && count($errors)>0  )
        <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          </div>
        @endif


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="{{ url('/accounting/trucks/addproducts') }}" style="margin-top: 20px;" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form_container">

          <div class="col-sm-12 col-md-7 col-lg-7 col-xs-12 col-sm-offset-2 col-md-offset-2 col-sm-offset-0">
            <div class="top_content">
              <h3>Add New Product to Truck</h3>
              <p>@lang('admin/employees.field_employee_text')</p>
            </div>

            <div class="form_container">
              <div class="col-sm-12">
                <table class="erp-table erp-ac-transaction-table payment-voucher-table">
              <thead>
                <tr>
                    <th class="col-chart">@lang('admin/entries.title_label')</th>
                    <th class="col-amount">Product</th>
                </tr>
            </thead>
            <tbody>
              <input type="hidden" value="0" name="id" id="id">                    
                      <tr class="tr">
                        <td class="col-chart" width="250" height="50">
                          <select name="trucks" id="truck" class="form-control1 chosen title">
                            <option value="0"> -- SELECT -- </option>
                            @if(isset($trucks) )
                              @foreach($trucks as $truck)
                                <option value="{{ $truck->id }}">{{ $truck->name }}</option>
                              @endforeach
                            @endif
                          </select>
                          
                          {{-- <input type="text" name="title[]" id="title" required="required" class="form-control1" placeholder="@lang('admin/entries.title_label')" /> --}}
                        </td>

                        <input type="hidden" value="0" name="id" id="id">                    
                        <td class="col-chart" width="250" height="50">
                          <select name="products" id="product" class="form-control1 chosen title">
                            <option value="0"> -- SELECT -- </option>
                            @if(isset($products) )
                              @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                              @endforeach
                            @endif
                          </select>
                          
                          {{-- <input type="text" name="title[]" id="title" required="required" class="form-control1" placeholder="@lang('admin/entries.title_label')" /> --}}
                        </td>
                      </tbody>
                      </table>
                      
                    </div>
              
              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                <label for="" class="input_label"></label>
                <input type="submit" name="submitButton" value="@lang('admin/common.button_submit')" class="btn btn-primary btn-block new-btn">
              </div>

              

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
  <script src="{{ asset('assets/js/timepicki.js')}}"></script>
  <script type='text/javascript'>
   
   

    $(document).ready(function (){
     
      $('form[data-toggle="validator"]').bootstrapValidator({
        excluded: [':disabled'],
      }).on('status.field.bv', function(e, data) {
        data.element.data('bv.messages').find('.help-block[data-bv-for="' + data.field + '"]').hide();
      });

    });

  </script>
@endsection