@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/timepicki.css') }}"/>
@endsection

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/accounting.edit_coa_txt')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('accounting/chart') }}">@lang('admin/accounting.chart_heading')</a>  / 
        <a href="#" class="active">@lang('admin/accounting.edit_coa_txt')</a>
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


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="{{ url('accounting/chart/edit', $chart->id) }}" style="margin-top: 20px;" enctype="multipart/form-data">

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form_container">

          {{-- Left From Colum --}}
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-3 col-md-offset-3 col-sm-offset-0">
            <div class="top_content">
              <h3>@lang('admin/accounting.edit_coa_txt')</h3>
              <p>@lang('admin/employees.field_employee_text')</p>
            </div>

            <div class="form_container">
              
              

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="name" class="input_label">@lang('admin/accounting.account_title')*</label>
                <input type="text" name="name" id="name" class="form-control1" placeholder="@lang('admin/accounting.account_type_title')*" required="required" value="{{ $chart->name }}" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="code" class="input_label">@lang('admin/accounting.account_code')*</label>
                <input type="text" name="code" id="code" class="form-control1" placeholder="@lang('admin/accounting.account_code')*" required="required" readonly="readonly" value="{{ $chart->code }}" />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <label for="account_type" class="input_label">@lang('admin/accounting.type_name_txt')*</label>

                <select name="account_type" id="account_type" data-placeholder="Choose a Types" class="chosen form-control1" tabindex="2">
                  @if(isset($types) && count($types) > 0)
                    @foreach($types as $type)
                    <optgroup label="{{ $type['name'] }}">
                      @if(isset($type['children']) && count($type['children']) > 0)
                        @foreach($type['children'] as $children)
                          @if($chart->type_id == $children['type_id'])
                            <option value="{{ $children['type_id'] }}" selected="selected"> -- {{ $children['name'] }}</option>
                          @else
                            <option value="{{ $children['type_id'] }}"> -- {{ $children['name'] }}</option>
                          @endif
                        @endforeach
                      @endif
                      </optgroup>
                    @endforeach
                  @endif
                </select>
               
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="balance_type" class="input_label">@lang('admin/accounting.balance_type_label')</label>
                <select name="balance_type" id="balance_type" class="form-control1" required="required">
                  <option value="dr" @if($chart->balance_type == "dr") selected="selected" @endif>@lang('admin/accounting.type_dr')</option>
                  <option value="cr" @if($chart->balance_type == "cr") selected="selected" @endif>@lang('admin/accounting.type_cr')</option>
                </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="opening" class="input_label">@lang('admin/accounting.account_opening')*</label>
                <input type="text" name="opening" id="opening" class="form-control1" data-bv-integer-message="The value is not an integer" placeholder="@lang('admin/accounting.account_opening')*" value="{{ $chart->opening_balance }}" />
              </div>



              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                <label for="submit" class="input_label"></label>

                <button type="submit" name="submitButton" class="btn btn-primary btn-block new-btn">Submit</button>
              </div>

              

            </div>
            
          </div>


          {{-- Right Form Column --}}

         
          
  
          </div>
        

        

        </form>

      </div>
      
      
      
    </div>
  </div>
</div>

@endsection
@section('scripts')
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script type="text/javascript">
  $(function() {
      $('.chosen').chosen();
      $('.chosen-deselect').chosen({ allow_single_deselect: true });
    });
</script>

  
  <script type="text/javascript">

    $(".datepicker").dateDropper();

    
    

</script>

<script>
$(document).ready(function() {
    $('form[data-toggle="validator"]')
        .find('[name="account_type"]')
            .chosen({
                width: '100%',
                inherit_select_classes: true
            })
            // Revalidate the color when it is changed
            .change(function(e) {
                $('form[data-toggle="validator"]').bootstrapValidator('revalidateField', 'account_type');
            })
            .end()
        .bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                account_type: {
                    validators: {
                        callback: {
                            message: 'Please choose 2-4 color you like most',
                            callback: function(value, validator, $field) {
                                // Get the selected options
                                var options = validator.getFieldElements('account_type').val();
                                return (options != null);
                            }
                        }
                    }
                },
                opening: {
                    validators: {
                        numeric: {
                          message: 'The value is not an integer',
                          decimalSeparator: '.'
                        }
                    }
                }

            }
        });
});


</script>

@endsection