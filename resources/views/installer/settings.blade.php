@extends('installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.environment.menu.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-cog fa-fw" aria-hidden="true"></i>
    {!! trans('installer_messages.environment.menu.title') !!}
@endsection

@section('container')


    <form method="post" action="{{ url('install?step=finish') }}" class="tabs-wrap" id="finalForm">
    <div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group {{ $errors->has('country') ? ' has-error ' : '' }}">
                    <label for="country">
                        {{ trans('installer_messages.environment.wizard.form.country_label') }}*
                    </label>
                    <select name="country" id="country">
                        @if(isset($countries) && count($countries) > 0)
                            @foreach($countries as $key=>$value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                            
                        @endif
                    </select>
                    
                    @if ($errors->has('country'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('country') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('timezone') ? ' has-error ' : '' }}">
                    <label for="timezone">
                        {{ trans('installer_messages.environment.wizard.form.timezone_label') }}*
                    </label>
                    <select name="timezone" id="timezone">
                        
                        @if(isset($zones) && count($zones) > 0)
                            @foreach($zones as $key=>$value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                            
                        @endif
                    </select>
                    
                    @if ($errors->has('timezone'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('timezone') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('email_enabaled') ? ' has-error ' : '' }}">
                    <label for="email_enabaled">
                        {{ trans('installer_messages.environment.wizard.form.email_enabaled_label') }}
                    </label>
                    <select name="email_enabaled" id="email_enabaled">
                       <option value="">Please select</option>
                       <option value="true">YES</option>
                       <option value="false">NO</option>
                    </select>
                    
                    @if ($errors->has('email_enabaled'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('email_enabaled') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('bank_account') ? ' has-error ' : '' }}">
                    <label for="bank_account">
                        {{ trans('installer_messages.environment.wizard.form.bank_account_label') }}
                    </label>
                    <input type="text" name="bank_account" id="bank_account" value="" placeholder="{{ trans('installer_messages.environment.wizard.form.bank_account_label') }}" />
                    
                    @if ($errors->has('bank_account'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('bank_account') }}
                        </span>
                    @endif
                </div>


               

                <div class="buttons">
                    <button class="button" onclick="showFinished();" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing..." id="load">
                        {{ trans('installer_messages.environment.wizard.form.buttons.setup_finished') }}
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

    </form>

   <script type="text/javascript">

    function showFinished(){
        $("#loading").css('display', 'block');
    }

    $(window).bind("load", function() {
       $("#loading").css('display', 'block');
    });

    $(window).load(function(){
        $("#loading").hide();
    });
   
   </script>


   <script>
      function showFinished() {
        console.log("load event detected!");

        //document.getElementById('load').style.visibility = 'show';
        document.getElementById("loading").style.display="block";

        document.getElementById("box").style.display="none";
        window.onload = showFinished;
      }
      
    </script>

   <script>
      // const showFinished = () => {
      //   console.log("load event detected!");
      // } 
      //window.onload = showFinished; 
    </script>

@endsection