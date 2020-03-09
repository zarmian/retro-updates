@extends('installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.environment.wizard.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-key" aria-hidden="true"></i>
    {!! trans('installer_messages.environment.wizard.verify_key') !!}
@endsection

@section('container')

    <form method="post" action="{{ url('install?step=verfiy') }}" class="tabs-wrap"  autocomplete="on">
            <div >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group {{ $errors->has('username') ? ' has-error ' : '' }}">
                    <label for="username">
                        {{ trans('installer_messages.environment.wizard.form.username_label') }}
                    </label>
                    <input type="text" name="username" id="username" value="" placeholder="{{ trans('installer_messages.environment.wizard.form.app_verfiy_username') }}" autocomplete="off" />
                    @if ($errors->has('username'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('verfiy_key') ? ' has-error ' : '' }}">
                    <label for="verfiy_key">
                        {{ trans('installer_messages.environment.wizard.form.verfiy_key_label') }}
                    </label>
                    <input type="text" name="verfiy_key" id="verfiy_key" value="" autocomplete="off" placeholder="{{ trans('installer_messages.environment.wizard.form.verfiy_key_label') }}" />
                    @if ($errors->has('verfiy_key'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('verfiy_key') }}
                        </span>
                    @endif
                </div>
                


                <div class="buttons">
                    <button class="button" onclick="showDatabaseSettings();return false">
                        {{ trans('installer_messages.environment.wizard.form.buttons.verfiy') }}
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            
          
        </form>

   
@endsection

@section('scripts')
    <script type="text/javascript">
        function checkEnvironment(val) {
            var element=document.getElementById('environment_text_input');
            if(val=='other') {
                element.style.display='block';
            } else {
                element.style.display='none';
            }
        }
        function showDatabaseSettings() {
            document.getElementById('tab2').checked = true;
        }
        function showApplicationSettings() {
            document.getElementById('tab3').checked = true;
        }
    </script>
@endsection