@extends('installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.environment.menu.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-user fa-fw" aria-hidden="true"></i>
    {!! trans('installer_messages.environment.menu.login_title') !!}
@endsection

@section('container')
<div id="loading" style="display: none">
    Loading content, please wait..
</div>

    <form method="post" action="{{ url('install?step=6') }}" class="tabs-wrap">
    <div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group {{ $errors->has('username') ? ' has-error ' : '' }}">
                    <label for="username">
                        {{ trans('installer_messages.environment.wizard.form.username_label') }}
                    </label>
                    <input type="text" name="username" id="username" value="" />
                    
                    @if ($errors->has('username'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('password') ? ' has-error ' : '' }}">
                    <label for="password">
                        {{ trans('installer_messages.environment.wizard.form.password_label') }}
                    </label>
                    <input type="password" name="password" id="password" value="" />
                    
                    @if ($errors->has('password'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>


                <div class="form-group {{ $errors->has('email') ? ' has-error ' : '' }}">
                    <label for="email">
                        {{ trans('installer_messages.environment.wizard.form.email_label') }}
                    </label>
                    <input type="text" name="email" id="email" value="" />
                    
                    @if ($errors->has('email'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>


               

                <div class="buttons">
                    <button class="button" onclick="showFinished();" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing..." id="load">
                        {{ trans('installer_messages.environment.wizard.form.buttons.setup_application') }}
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

    </form>

   <script type="text/javascript">

    // function showFinished(){
    //     $("#loading").css('display', 'block');
    // }

    // $(window).bind("load", function() {
    //    $("#loading").css('display', 'block');
    // });

    // $(window).load(function(){
    //     $("#loading").hide();
    // });
   
   </script>


   <script>
      // function showFinished() {
      //   console.log("load event detected!");

      //   document.getElementById('load').style.visibility = 'hidden';
      //   window.onload = showFinished;
      // }
      
    </script>

   <script>
      //const showFinished = () => {
        //console.log("load event detected!");
      //} 
      //window.onload = showFinished; 
    </script>

@endsection
