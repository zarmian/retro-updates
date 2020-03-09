@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/users.manage')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
      <a href="#" class="active">@lang('admin/users.manage')</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

<section class="find-search">
  <div class="container">
    <div class="row">

      <div class="col-lg-12">
    
        <div class="col-lg-4 col-lg-offset-8">

        <div class="col-lg-6 col-md-2 col-sm-3 col-xs-12 col-sm-offset-8 col-md-offset-9 col-lg-offset-3">
          <select class="select-page" id="per_page">
            <option value="12" @if($per_page == 12) selected="selected" @endif>@lang('admin/common.per_page_12')</option>
              <option value="24" @if($per_page == 24) selected="selected" @endif>@lang('admin/common.per_page_24')</option>
              <option value="50" @if($per_page == 50) selected="selected" @endif>@lang('admin/common.per_page_50')</option>
              <option value="100" @if($per_page == 100) selected="selected" @endif>@lang('admin/common.per_page_100')</option>
          </select>

        </div>

        
        <div class="col-lg-3 col-md-1 col-sm-1 col-xs-12 plus-margin">
        <button class="plus" onclick="window.location = '{{ url('/manage-users/create') }}'">+</button></div>

          
        </div>

      </div>


    </div>
  </div>
</section>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
     

      @if(Session::has('msg'))
        <div class="alert alert-success">{{ Session::get('msg') }}</div>
      @endif
      
      <div id="products" class="row list-group">
        @if(isset($users) && count($users) > 0)
        @foreach($users as $user)

        <div class="item col-xs-12 col-lg-4 grid-group-item">
          <div class="thumbnail">
            <div class="row">
            <div class="item grid-group-item">
              <ul>
                  <li class="emp-left">
                  @if(!empty($user->image) && $user->image <> NULL)
                    <img class="group list-group-image" src="{{ url('storage/app/avatar/'.$user->image)}}" alt="" width="80"  height="80"><br>
                  @else
                    <img class="group list-group-image" src="{{ url('assets/images/img-person.jpg')}}" alt="" width="80"  height="80"><br>
                  @endif
                    

                    <a href="{{ url('/manage-users/edit/'.$user->id) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                    <a href="{{ url('/manage-users/remove/'.$user->id) }}" class="is_delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                    </li>
                   <li class="emp-right">
                    <div class="caption">
                 <ul>
                      <li class="name">{{ $user->fullName() }} 
                        
                        <div class="dest">@lang('admin/users.cell') {{ $user->phone_no }} </div>
                        <div class="dest">@lang('admin/users.email') {{ $user->email }} </div>
                      </li>
                     </ul>
                     </div>
                    </li>
                </ul>
            </div>
            </div>
          </div>
        </div>


        
        @endforeach
        <div class="col-xs-12">{!! $users->appends(\Input::except('page'))->render() !!}</div>

        @else
        <div class="alert alert-warning">@lang('admin/messages.not_found')</div>
        @endif
        
        
      </div>
      
    </div>
  </div>
</div>


<script>
  $(function(){
    // bind change event to select
    $('#per_page').on('change', function () {
    var url = $(this).val(); // get selected value
    if (url) { // require a URL
    window.location = '?per_page='+url; // redirect
    }
    return false;
    });
  });

  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });
</script>
@endsection