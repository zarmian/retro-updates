@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/entries.sales_heading_txt')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('accounting/sales') }}">@lang('admin/entries.sales_heading_txt')</a>  / 
        <a href="#" class="active">@lang('admin/entries.create_sales_heading')</a>
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
        @if(Session::has('error'))
          <div class="alert alert-danger">
            {{ Session::get('error') }}
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

         <form data-toggle="validator" role="form" action="{{ url('accounting/sales/save') }}" method="POST" enctype="multipart/form-data" class="erp-form erp-ac-transaction-form">
         
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="form_container">

          
          {{-- Left From Colum --}}
          <div class="col-sm-9 col-md-9 col-lg-9 col-xs-12 col-sm-offset-2">
            <div class="top_content">
              <h3>@lang('admin/entries.create_sales_heading')</h3>
              <p>@lang('admin/users.field_employee_text')</p>
            </div>

            <div class="">

                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                  <label for="customer" class="input_label">@lang('admin/entries.customer_label')*</label>
                  <select name="customer" id="customer" class="form-control1 chosen" required="required">
                    <option value="">@lang('admin/common.select_customer_txt')</option>
                    @if(isset($customers)  )
                      @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                      @endforeach
                    @endif
                  </select>
                </div>


                 <div class="col-md-5 col-sm-5 col-lg-5 col-xs-5 form-group">
                  <label for="reference" class="input_label">Purchase Record</label>
                  <input type="hidden" value="0" name="id" id="id">                    
                      <tr class="tr">
                        <td class="col-chart" width="250" height="50">



                          
                          <select name="purchases[]" id="purchases" class="form-control1 chosen purchases">
                            <option value="0"> -- SELECT -- </option>
                            @if(isset($purchases) )
                            
                              @foreach($purchases as $purchase)
                          <option value="{{ $purchase['id'] }}">{{ $purchase['truck'] }}   {{ $purchase['product'] }}  {{ $purchase['date'] }}</option>
                              @endforeach
                            @endif
                          </select>
                          
                          {{-- <input type="text" name="title[]" id="title" required="required" class="form-control1" placeholder="@lang('admin/entries.title_label')" /> --}}
                        </td>
                </div>

                <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group clearfix">
                  <label for="invoice_no" class="input_label">@lang('admin/entries.invoice_no_label')*</label>
                  
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">INV</span>
                    <input type="text" name="invoice_number" id="invoice_number" class="form-control1" placeholder="@lang('admin/entries.invoice_no_label')*" value="{{ $invoice_number }}" required="required" readonly="readonly" style="border-bottom-left-radius: 0px;border-top-left-radius: 0px;" />

                  </div>
                  
                  
                </div>

               

                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group clearfix">
                  <label for="invoice_date" class="input_label">@lang('admin/entries.invoice_date_label')*</label>
                  <input type="text" name="invoice_date" id="invoice_date" class="form-control1 datepicker" placeholder="@lang('admin/entries.invoice_date_label')" required="required" value="{{ old('date') }}" data-min-year="{{ date('Y',strtotime('-10 year',time())) }}" data-max-year="{{ date('Y',strtotime('+10 year',time())) }}"/>
                </div>

                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
                  <label for="due_date" class="input_label">@lang('admin/entries.invoice_due_date_label')*</label>
                  <input type="text" name="due_date" id="due_date" class="form-control1 datepicker" placeholder="@lang('admin/entries.invoice_due_date_label')" required="required" value="{{ old('date') }}" data-min-year="{{ date('Y',strtotime('-10 year',time())) }}" data-max-year="{{ date('Y',strtotime('+10 year',time())) }}" />
                </div>
                {{-- <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group clearfix">
                  <label for="Origin" class="input_label">Origin*</label>
                  <input type="hidden" value="0" name="id" id="id">                    
                      <tr class="tr">
                        <td class="col-chart" width="250" height="50">
                          <select name="origin" id="origin" class="form-control1 chosen title">
                            <option value="0"> -- SELECT -- </option>
                            @if(isset($origins) )
                              @foreach($origins as $origin)
                                <option value="{{ $origin->id }}">{{ $origin->origin }}</option>
                              @endforeach
                            @endif
                          </select>                          
                        </td>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
                  <label for="Origin" class="input_label">Destination*</label>
                  <input type="hidden" value="0" name="id" id="id">                    
                      <tr class="tr">
                        <td class="col-chart" width="250" height="50">
                          <select name="destination" id="destination" class="form-control1 chosen title">
                            <option value="0"> -- SELECT -- </option>
                            @if(isset($destinations) )
                              @foreach($destinations as $destination)
                                <option value="{{ $destination->id }}">{{ $destination->destination }}</option>
                              @endforeach
                            @endif
                          </select>                          
                        </td>
                </div> --}}
                <div class="col-sm-12">
                  <table class="erp-table erp-ac-transaction-table payment-voucher-table">
                    <thead>
                        <tr>
                            <th class="col-chart"></th>
                            <th class="col-desc"></th>
                            <th class="col-desc">@lang('admin/entries.account_qty_label')</th>
                            <th class="col-desc">@lang('admin/entries.account_unit_price_label')</th>
                            <th class="col-amount">@lang('admin/entries.account_amount_label')</th>
                        </tr>
                    </thead>

                    <tbody>
                    <input type="hidden" value="0" name="id" id="id">                    
                      <tr class="tr">
                        <td class="col-chart" width="250" height="50">



                          
                          {{-- <select name="title[]" id="title" class="form-control1 chosen title">
                            <option value="0"> -- SELECT -- </option>
                            @if(isset($products) )
                              @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                              @endforeach
                            @endif
                          </select> --}}
                          
                          {{-- <input type="text" name="title[]" id="title" required="required" class="form-control1" placeholder="@lang('admin/entries.title_label')" /> --}}
                        </td>


                        <td class="col-chart" width="200" height="50">
                          {{-- <select name="truck_product[]" id="truck_product" class="form-control1 chosen product">
                            <option value="0"> -- SELECT -- </option> --}}
                            
                            
                          </select>

                        <td class="col-desc" width="70">
                            <input type="text" name="line_qty[]" id="line_qty[]" class="line_qty form-control1" value="1" placeholder="Qty" required="required" />
                        </td>

                        <td class="col-desc" width="100">
                            <input type="text" value="" name="line_unit_price[]" id="line_unit_price[]" class="line_price form-control1" placeholder="0.0000" required="required" /> 
                        </td>

                        

                        <td class="col-amount">
                          <input type="text" value="" name="line_total[]" id="line_total[]" class="line_total form-control1" placeholder="0.0000" readonly="" required="required" />
                        </td>

                        {{--<td class="col-action">
                            <a href="" class="remove-line"><span class="fa fa-trash"></span></a>
                        </td>--}}

                      </tr>

                                      

                            
                    </tbody>
                    <tfoot>
                        <tr>
{{--                            <th><a href="javascript:void(0)" class="button add-line">@lang('admin/entries.add_new_line_button_txt')</a></th>--}}
                            <th class="align-right"></th>
                            <th class="align-right"></th>
                            <th class="align-right"></th>
                            <th class="align-right" align="right">@lang('admin/entries.sub_total_txt')</th>
                           
                            <th class="col-amount">
                                <input type="text" name="sub_total" class="sub-total form-control1" readonly="" placeholder="0.0000" />
                            </th>
                        </tr>

                        <tr>
                            <th></th>
                            <th class="align-right"></th>
                            <th class="align-right"></th>
                            <th class="align-right" align="right">Shortage</th>
                           
                            <th class="col-amount">
                                <input type="text" name="discount" class="discount form-control1" placeholder="0.00" value="0.0000" />
                            </th>
                        </tr>
                        

                        @if(isset($vat) && $vat == 1)

                        <tr>
                            <th></th>
                            <th class="align-right"></th>
                            <th class="align-right"></th>
                            <th class="align-right" align="right">VAT</th>
                           
                            <th class="col-amount">
                                <select name="vat_tax_id" id="vat_tax_id" class="form-control1 vat_tax">
                                @if(isset($tax) )
                                  @foreach($tax as $tax)
                                    <option value="{{ $tax->id }}" data-rate="{{ $tax->rate }}">{{ $tax->name }}</option>
                                  @endforeach
                                @endif
                                </select>
                            </th>
                        </tr>

                        @else
                        <input type="hidden" name="vat_tax_id" value="0" />

                        @endif

                        <tr>
                            <th></th>
                            <th class="align-right"></th>
                            <th class="align-right"></th>
                            <th class="align-right" align="right">@lang('admin/entries.total_txt')</th>
                           
                            <th class="col-amount">
                                <input type="text" name="total" class="price-total form-control1" readonly="" placeholder="0.0000" />
                            </th>
                        </tr>
                       

                        <tr>
                          <td height="40" colspan="4"></td>
                        </tr>
                    </tfoot>
                </table>
                </div>

                



                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <textarea name="note" id="note" cols="30" rows="10" class="form-control2" placeholder="@lang('admin/entries.reference_textarea_label')">{{ old('note') }}</textarea>
                </div>

                


              </div>
              
            </div>


            {{-- Right Form Column --}}

            

            <div class="col-sm-10 col-sm-offset-2">
              <div class="col-sm-2 col-lg-2 col-md-2 col-xs-12">
              <label for="" class="input_label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
              <button type="submit" name="submitButton" class="btn btn-primary btn-block new-btn">@lang('admin/users.submit_button')</button>
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
$(".chosen").select2();
</script>

<script type="text/javascript">
  $(document).on('change', '.title', function (){

   var self = $(this);
   var tr = self.closest('.tr')
   var id = self.val();
   var base_url = site.base_url;
   $('#truck_product').find('option').remove();

   $.ajax({
     url: base_url+'/accounting/trucks/ajax-products',
     type: 'POST',
     dataType: 'json',
     data: {'_token': '{{ csrf_token() }}', id: id},
     success: function($data, textStatus, xhr){
       
       if($data.error == 0){
         var len = 0;
         
         // var qty = tr.find('.line_qty').val();
         // tr.find('.product').val(data.row.id);
         len = $data.len;
         
         if(len > 0){
              // Read data and create <option >
              for(var i=0; i<len; i++){
               
                var id = $data.data[i].id;
                
                var name = $data.data[i].name;
                var qty = $data.data[i].qty;
               
                var option = "<option value='"+id+"'>"+name+"</option>"; 
                

                $("#truck_product").append(option);
                

              }
             }
         

         //amount column

         var final_price = parseFloat(data.row.price) * parseFloat(qty)
         tr.find('.line_total').val(final_price);
/////////////////////////////////////////////////////

         var tables = $('.payment-voucher-table');

         var totals = 0;

         tables.find('tbody > tr').each(function(index, el) {
           var rows    = $(el);
           var total  = ( rows.find('input.line_total').val() ) || '0';

           totals +=  parseFloat( total );

         });

         $('.sub-total').val(totals);
         $('.price-total').val(totals);

       }

     }
   });



 });
</script>

<script type="text/javascript">
  $(document).on('change', '.vat_tax', function (){

    var self = $(this);
    var id = self.val();
    var base_url = site.base_url;

    $.ajax({
      url: base_url+'/accounting/sales/vat-price',
      type: 'POST',
      dataType: 'json',
      data: {'_token': '{{ csrf_token() }}', id: id},
      success: function(data, textStatus, xhr){
        console.log(data.row.rate);

        if(data.error == 0){


          var sub_total = $('.sub-total').val();

          if(sub_total > 0){
            var discount = $('.discount').val();
            var tax_amount = data.row.rate;

            var price_from_discount = parseFloat(sub_total) - parseFloat(discount);

            var total_vat = parseFloat(price_from_discount) / 100;
            var final_vat = total_vat * tax_amount;

            var final_total_price = price_from_discount + final_vat;

            $('.price-total').val(final_total_price.toFixed(2));
          } 
          
         

        }
        
      } 
    });
    


  });


    $(document).on('keypress', '.discount', function (){

    var self = $(this);
    var id = $('.vat_tax').val();
    var base_url = site.base_url;

    $.ajax({
      url: base_url+'/accounting/sales/vat-price',
      type: 'POST',
      dataType: 'json',
      data: {'_token': '{{ csrf_token() }}', id: id},
      success: function(data, textStatus, xhr){
        console.log(data.row.rate);

        if(data.error == 0){


          var sub_total = $('.sub-total').val();

          if(sub_total > 0){

            var discount = $('.discount').val();

            // if ( discount > 0 ) {
            //     price -= ( price * discount ) / 100;
            // }

            var tax_amount = data.row.rate;

            var price_from_discount = parseFloat(sub_total) - parseFloat(discount);

            var total_vat = parseFloat(price_from_discount) / 100;
            var final_vat = total_vat * tax_amount;

            var final_total_price = price_from_discount + final_vat;

            $('.price-total').val(final_total_price.toFixed(2));
          } 
        }
        
      } 
    });

  });

    function calculate_tax(){


	    var id = $('.vat_tax').val();
	    var base_url = site.base_url;

	    $.ajax({
	      url: base_url+'/accounting/sales/vat-price',
	      type: 'POST',
	      dataType: 'json',
	      data: {'_token': '{{ csrf_token() }}', id: id},
	      success: function(data, textStatus, xhr){
	        console.log(data.row.rate);

	        if(data.error == 0){

	          var sub_total = $('.sub-total').val();

	          if(sub_total > 0){

	            var discount = $('.discount').val();

	            // if ( discount > 0 ) {
	            //     price -= ( price * discount ) / 100;
	            // }

	            var tax_amount = data.row.rate;

	            var price_from_discount = parseFloat(sub_total) - parseFloat(discount);

	            var total_vat = parseFloat(price_from_discount) / 100;
	            var final_vat = total_vat * tax_amount;

	            var final_total_price = price_from_discount + final_vat;

	            $('.price-total').val(final_total_price.toFixed(2));
	          } 
	        }
	        
	      } 
	    });


    }
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('form[data-toggle="validator"]').bootstrapValidator();
  });
</script>

<script type="text/javascript">
 
  $('.datepicker').dateDropper();
</script>


@endsection