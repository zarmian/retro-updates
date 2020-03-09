<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>

        <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">

    </head>
    <body>

        <div class="container-fluid">
            <div class="maxer_bg">
                <div class="container">
                    <div class="row">
                        <div class="login_box">
                                <div class="maxer_circle">
                                    
                                    <div class="logo_area">
                                       <img src="{{ URL::asset('assets/images/maxer-logo.png') }}" alt="">
                                        <div class="login_sologan">Maxer a powerful <span>erp</span> <br> complete business solutions</div>
                                    </div>

                                    <form method="POST" action="{{ url('login') }}">
                                        {!! csrf_field() !!}

                                        <div class="login_form">
                                            <div class="form_input_username">
                                                <input type="text" name="username" class="login-input" Placeholder="Username" />
                                            </div>

                                            <div class="form_input_password">
                                                <input type="password" name="password" class="login-input" Placeholder="Password" />
                                            </div>
                                        </div>

                                        <input type="submit" class="submit-btn" value="LOGIN">

                                    </form>

                                    <div class="login_bottom">
                                        <div class="block_msg">

                                            @if (count($errors) > 0)
                                                @foreach ($errors->all() as $error)
                                                    {{ $error }}
                                                @endforeach
                                            @endif
                                          

                                            @if(Session::has('invalid'))
                                                <div class="login_error">
                                                    {{ Session::get('invalid') }}
                                                </div>
                                            @endif

                                            @if(Session::has('error'))
                                                <div class="login_error">
                                                    {{ Session::get('error') }}
                                                </div>
                                            @endif

                                            @if(count($errors) === 0 && !Session::has('invalid') && !Session::has('error'))
                                                Explore your world with <b>Maxer!</b>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
      
        
        
        </body>
    </html>