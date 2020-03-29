@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>Manage Products</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
      <a href="#" class="active">Manage Products</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

<section class="find-search">
  <div class="container">
    <div class="row">

      <form action="" method="GET">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
        <input type="text" name="name" id="name" class="filter-date-input" placeholder="Product Name" value="{{ \Request::get('name') }}"  />
       </div>

       <div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 plus-margin">
        <button type="submit" class="search"><i class="fa fa-search" aria-hidden="true"></i></button>
       </div>
      </form>

    
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
          <select class="select-page" id="per_page">
            <option value="12" @if($per_page == 12) selected="selected" @endif>@lang('admin/common.per_page_12')</option>
              <option value="24" @if($per_page == 24) selected="selected" @endif>@lang('admin/common.per_page_24')</option>
              <option value="50" @if($per_page == 50) selected="selected" @endif>@lang('admin/common.per_page_50')</option>
              <option value="100" @if($per_page == 100) selected="selected" @endif>@lang('admin/common.per_page_100')</option>
          </select>

        </div>

        
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 plus-margin">
        <a href="{{ url('accounting/trucks/add') }}" class="plus">+</a></div>


    </div>
  </div>
</section>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
     

      @if(Session::has('msg'))
        <div class="alert alert-success">{{ Session::get('msg') }}</div>
      @endif


      <div id="products" class="list-group">

      <div class="row">
        
        @if(isset($product) )
        @foreach($product as $item)

        
        
          
           <div class="item col-xs-12 col-lg-3 col-sm-3">
          <div class="thumbnail">
            <div class="row">
              
                <ul class="list-detail">
                  <li>
                    <div class="caption">
                      <ul>
                        <li class="name">Name: <b> {{ $item['name'] }}</li>
                        {{-- <li class="name">Available Quantity: <b> {{ $product['price'] }}</li> --}}
                      </ul>
                    </div>
                  </li>
                </ul>
                <ul class="inner-btn clearfix">
{{--                  <li><a href="{{ url('accounting/trucks/edit/'.$product['id']) }}" data-toggle="tooltip" title="Edit"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></li>--}}
                  <li><a href="{{ url('accounting/products/delete/'.$item['id']) }}" data-toggle="tooltip" title="Delete" class="is_delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>
                </ul>
           
            </div>
          </div>
        </div>
        

      
          
         



        
        @endforeach
          <div class="col-xs-12">
            {!! $pages !!}
          </div>
        @else
          <div class="alert alert-warning">@lang('admin/messages.not_found')</div>
        @endif

        </div>
        
        
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

    $('.chosen').select2();
  });

  $('.datepicker').dateDropper();
</script>
@endsection