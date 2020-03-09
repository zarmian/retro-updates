@extends('layouts.app')

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row"> 
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/common.setting_heading')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="javascript:void();" class="active">@lang('admin/common.setting_heading')</a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')


<div class="container mainwrapper margin-top">
  <div class="row">

    <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12">
      
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
    </div>

    <form action="{{ url('/setting') }}" data-toggle="validator"] method="POST" enctype="multipart/form-data">



    <div class="margin-top">
      
      <div class="col-sm-6">
        
        <div class="top_content">
          <h3>@lang('admin/common.general_setting_heading')</h3>
          <p>@lang('admin/employees.field_employee_text')</p>
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label">@lang('admin/common.company_name_label')*</label>
          <input type="text" name="st[BUSINESS_NAME]" value="{{ $BUSINESS_NAME }}" class="form-control1">
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label">@lang('admin/common.ntn_label')</label>
          <input type="text" name="st[NTN_NO]" value="{{ $NTN_NO }}" class="form-control1">
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label">@lang('admin/common.email_label')*</label>
          <input type="text" name="st[BUSINESS_EMAIL]" value="{{ $BUSINESS_EMAIL }}" class="form-control1">
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label">@lang('admin/common.website_label')</label>
          <input type="text" name="st[BUSINESS_WEBSITE]" value="{{ $BUSINESS_WEBSITE }}" class="form-control1">
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label">@lang('admin/common.phone_label')</label>
          <input type="text" name="st[BUSINESS_PHONE]" value="{{ $BUSINESS_PHONE }}" class="form-control1">
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label">@lang('admin/common.mobile_label')</label>
          <input type="text" name="st[BUSINESS_MOBILE]" value="{{ $BUSINESS_MOBILE }}" class="form-control1">
        </div>

        <div class="form-group col-sm-12">
          <label for="" class="input_label">@lang('admin/common.address_label')</label>
          <textarea name="st[BUSINESS_ADDRESS]" id="" cols="30" rows="10" class="form-control2">{!! $BUSINESS_ADDRESS !!}</textarea>
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label">@lang('admin/common.country_label')</label>
          <select name="st[BUSINESS_COUNTRY]" id="" class="form-control1 chosen">
            <option value="">@lang('admin/common.select_option_txt')</option>
            @if(isset($countries) && count($countries) > 0)
              @foreach($countries as $country)
                @if($country->id == $BUSINESS_COUNTRY)
                  <option value="{{ $country->id }}" selected="selected">{{ $country->country_name }}</option>
                @else
                  <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                @endif
              @endforeach
            @endif
          </select>
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label">@lang('admin/common.email_enable_label')</label>
          <select name="st[ENABLE_EMAIL]" id="" class="form-control1">
            <option value="">@lang('admin/common.select_option_txt')</option>
            <option value="true" @if($ENABLE_EMAIL == 'true') selected="selected" @endif>YES</option>
            <option value="false" @if($ENABLE_EMAIL == 'false') selected="selected" @endif>NO</option>
          </select>
        </div>


        <div class="form-group col-sm-6">
          <label for="" class="input_label">@lang('admin/common.off_days_label')</label>
          <select name="st[OFFDAYS][]" id="" data-placeholder="@lang('admin/common.select_off_days_txt')" multiple class="form-control1 chosen" tabindex="4">
            <option value="">@lang('admin/common.select_option_txt')</option>
            @if(isset($days) && count($days) > 0)
              @foreach($days as $key=>$value)
              @if(in_array($value, $OFFDAYS))
                <option value="{{ $value }}" selected="selected">{{ $value }}</option>
              @else
                <option value="{{ $value }}">{{ $value }}</option>
              @endif
              @endforeach
            @endif
          </select>
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label">@lang('admin/common.timezone_txt')</label>
          <select name="st[TIMEZONES]" id="" class="form-control1 chosen">
            <option value="">@lang('admin/common.select_option_txt')</option>
            @if(isset($timezones) && count($timezones) > 0)
              @foreach($timezones as $timezone)
              @if($timezone->zone_name == $TIMEZONES)
                <option value="{{ $timezone->zone_name }}" selected="selected">{{ $timezone->zone_name }}</option>
              @else
                <option value="{{ $timezone->zone_name }}">{{ $timezone->zone_name }}</option>
              @endif
              @endforeach
            @endif
          </select>
        </div>

        <div class="form-group col-sm-12">
          <label for="" class="input_label"></label>

          <div style="width: 200px;">
            <div class="slim" data-service="{{ url('/setting/logo') }}">
            @if($BUSINESS_LOGO_IMAGE <> NULL && file_exists(storage_path().'/app/logo/'.$BUSINESS_LOGO_IMAGE))
                    <img src="{{ asset('storage/app/logo/'.$BUSINESS_LOGO_IMAGE) }}" alt="">
                   @endif
              <input type="file" name="logo">
            </div>
            

          </div>
          
        </div>

        <div class="form-group col-sm-3">
          <label for="" class="input_label"></label>
          <button type="submit" class="btn btn-danger btn-block new-btn">@lang('admin/common.save_setting_btn')</button>
        </div>

      </div>
      <div class="col-sm-6">
        
        <div class="top_content">
          <h3>@lang('admin/common.finance_setting_heading')</h3>
          <p>@lang('admin/employees.field_employee_text')</p>
        </div>

       

        <div class="form-group col-sm-6">
          <label for="" class="input_label">@lang('admin/common.default_currency_label')</label>
          <select name="st[DEFAULT_CURRENCY]" id="" class="form-control1 chosen">
            <option value="">@lang('admin/common.select_option_txt')</option>
            @if(isset($countries) && count($countries) > 0)
              @foreach($countries as $country)
              @if($country->id == $DEFAULT_CURRENCY)
                <option value="{{ $country->id }}" selected="selected">{{ $country->currency_code }} - {{ $country->country_name }}</option>
              @else
                <option value="{{ $country->id }}">{{ $country->currency_code }} - {{ $country->country_name }}</option>
              @endif
              @endforeach
            @endif
          </select>
          </select>
        </div>



        <div class="form-group col-sm-6">
          <label for="" class="input_label">@lang('admin/common.thousand_sep_label')</label>
          <input type="text" name="st[THOUSAND_SEPRETOR]" value="{{ $THOUSAND_SEPRETOR }}" class="form-control1">
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label">@lang('admin/common.decimal_label')</label>
          <input type="text" name="st[DECIMAL_SEPRETOR]" value="{{ $DECIMAL_SEPRETOR }}" class="form-control1">
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label">TAX</label>
          <select name="st[VAT_TAX]" id="" class="form-control1 chosen">
            <option value="">@lang('admin/common.select_option_txt')</option>
              
                <option value="1" @if($VAT_TAX == '1') selected="selected" @endif>Enable</option>
                <option value="0" @if($VAT_TAX == '0') selected="selected" @endif>Disable</option>
              
          </select>
        </div>


        <div class="col-sm-12"><div class="top_content">
          <h3>@lang('admin/common.email_setting_heading')</h3>
          <p>@lang('admin/employees.field_employee_text')</p>
        </div></div>

        <div class="form-group col-sm-12">
          <label for="" class="input_label">@lang('admin/common.from_name_label')</label>
          <select name="st[MAIL_BY]" id="mail_by" class="form-control1 chosen">
            <option value="">@lang('admin/common.select_option_txt')</option>
            <option value="gmail" @if($MAIL_BY == 'gmail') selected="selected" @endif>@lang('admin/common.gmail_option_txt')</option>
            <option value="webmail" @if($MAIL_BY == 'webmail') selected="selected" @endif>@lang('admin/common.webmail_option_txt')</option>
          </select>
        </div>


        <div class="mblock" id="gmail" @if($MAIL_BY != 'gmail') style="display:none" @endif>

          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.gmail_driver')</label>
            <input type="text" name="st[GMAIL_DRIVER]" value="{{ $GMAIL_DRIVER }}" class="form-control1">
          </div>
          
          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.gmail_host')</label>
            <input type="text" name="st[GMAIL_HOST]" value="{{ $GMAIL_HOST }}" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.gmail_username')</label>
            <input type="text" name="st[GMAIL_USERNAME]" value="{{ $GMAIL_USERNAME }}" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.gmail_password')</label>
            <input type="text" name="st[GMAIL_PASSWORD]" value="{{ $GMAIL_PASSWORD }}" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.gmail_port')</label>
            <input type="text" name="st[GMAIL_PORT]" value="{{ $GMAIL_PORT }}" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.gmail_encryption')</label>
            <input type="text" name="st[GMAIL_ENCRYPTION]" value="{{ $GMAIL_ENCRYPTION }}" class="form-control1">
          </div>
          
          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.from_email_label')</label>
            <input type="text" name="st[GMAIL_FROM_ADDRESS]" value="{{ $GMAIL_FROM_ADDRESS }}" class="form-control1">
          </div>


          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.from_name_label')</label>
            <input type="text" name="st[GMAIL_FROM_NAME]" value="{{ $GMAIL_FROM_NAME }}" class="form-control1">
          </div>
        </div>

        <div class="mblock" id="webmail" @if($MAIL_BY != 'webmail') style="display:none" @endif>
            <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.gmail_driver')</label>
            <input type="text" name="st[MAIL_DRIVER]" value="{{ $MAIL_DRIVER }}" class="form-control1">
          </div>
          
          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.gmail_host')</label>
            <input type="text" name="st[MAIL_HOST]" value="{{ $MAIL_HOST }}" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.gmail_username')</label>
            <input type="text" name="st[MAIL_USERNAME]" value="{{ $MAIL_USERNAME }}" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.gmail_password')</label>
            <input type="text" name="st[MAIL_PASSWORD]" value="{{ $MAIL_PASSWORD }}" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.gmail_port')</label>
            <input type="text" name="st[MAIL_PORT]" value="{{ $MAIL_PORT }}" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.gmail_encryption')</label>
            <input type="text" name="st[MAIL_ENCRYPTION]" value="{{ $MAIL_ENCRYPTION }}" class="form-control1">
          </div>
          
          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.from_email_label')</label>
            <input type="text" name="st[MAIL_FROM_ADDRESS]" value="{{ $MAIL_FROM_ADDRESS }}" class="form-control1">
          </div>


          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.from_name_label')</label>
            <input type="text" name="st[MAIL_FROM_NAME]" value="{{ $MAIL_FROM_NAME }}" class="form-control1">
          </div>
        </div>


        <div class="mblock" id="mail" @if($MAIL_BY != 'mail') style="display:none" @endif>
           
          
          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.from_email_label')</label>
            <input type="text" name="st[EMAIL_FROM_ADDRESS]" value="{{ $EMAIL_FROM_ADDRESS }}" class="form-control1">
          </div>


          <div class="form-group col-sm-6">
            <label for="" class="input_label">@lang('admin/common.from_name_label')</label>
            <input type="text" name="st[EMAIL_FROM_NAME]" value="{{ $EMAIL_FROM_NAME }}" class="form-control1">
          </div>
        </div>

        


        <div class="form-group col-sm-12 hidden">
          <label for="" class="input_label">@lang('admin/common.invoice_voucher_label')</label>
          <textarea name="st[INVOICE_VOUCHER_TERMS]" id="st[INVOICE_VOUCHER_TERMS]" cols="30" rows="10" class="form-control2">{{ $INVOICE_VOUCHER_TERMS }}</textarea>
        </div>





      </div>

    </div>

    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    </form>


  </div>
</div>


@endsection

<style type="text/css">
/* Adjust feedback icon position */
.has-feedback .form-control-feedback {
    right: -30px;
}
</style>
@section('scripts')



<script src="{{ asset('assets/chosen/chosen.jquery.js')}}"></script>
<link rel="stylesheet" href="{{ asset('assets/slim/slim.min.css')}}">
<script type="text/javascript" src="{{ asset('assets/slim/slim.commonjs.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/slim/slim.amd.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/slim/slim.global.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/slim/slim.kickstart.min.js')}}"></script>

<script>
      $(function() {
        $('.chosen').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
      });
    </script>

<script>
$(document).ready(function() {
    $('form[data-toggle="validator"]')
        .bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                'st[BUSINESS_NAME]': {
                    validators: {
                        notEmpty: {
                            message: ''
                        }
                    }
                },
                'st[BUSINESS_EMAIL]': {
                    verbose: false,
                    validators: {
                        notEmpty: {
                            message: 'The email address is required and can\'t be empty'
                        },
                        emailAddress: {
                            message: 'The input is not a valid email address'
                        },
                        stringLength: {
                            max: 512,
                            message: 'Cannot exceed 512 characters'
                        }
                    }
                }

            }
        });
}).on('error.field.bv', function(e, data) {
      data.element.data('bv.messages').find('.help-block[data-bv-for="' + data.field + '"]').hide();
  });


</script>

<script type="text/javascript">
      $(function() {
        $('#mail_by').change(function(){
            $('.mblock').hide();
            $('#' + $(this).val()).show();
        });
    });
</script>

@endsection