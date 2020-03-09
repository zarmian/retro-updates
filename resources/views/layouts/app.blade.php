<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ config('app.name') }}</title>

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> --}}
<script src="{{ asset('assets/js/jquery.min.js')}}"></script>
<link href="{{ asset('assets/bootstrap/css/bootstrap.css?v=1.23')}}" type="text/css" rel="stylesheet">

<link rel="stylesheet" href="http://alxlit.name/bootstrap-chosen/bootstrap.css">
<link href="{{ asset('assets/css/flexnav.css') }}" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/validator/dist/css/bootstrapValidator.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/sweetalert2/dist/sweetalert2.min.css') }}">
<link href="{{ asset('assets/select2/css/select2.min.css')}}" type="text/css" rel="stylesheet">
<!-- custom css -->
<link href="{{ asset('assets/datepicker/datedropper.css') }}" rel="stylesheet" type="text/css" />

  <!-- include summernote -->
  <link rel="stylesheet" href="{{ asset('assets/editor/dist/summernote.css')}}">
  <script type="text/javascript" src="{{ asset('assets/editor/dist/summernote.js')}}"></script>
  
<!-- dateDropper lib -->
<script src="{{ asset('assets/datepicker/datedropper.js') }}"></script>
<link href="{{ asset('assets/font-awsome/css/font-awesome.min.css') }}" type="text/css" rel="stylesheet">

<link href="{{ asset('assets/css/stylesheet-main.css?v=1.3')}}" type="text/css" rel="stylesheet">



@yield('head')

<script type="text/javascript">
  var site = <?php echo json_encode(array('base_url' => url('/'))); ?>
</script>

</head>

<body>
<!-- header-->
@include('layouts.header')
<!-- header-->
@include('layouts.nav')
<!-- menu --> 

<!-- breadcrumb --> 
@yield('breadcrumb')

@yield('search')
<!-- Main Wrapper-->

@yield('content')

<div class="modal fade" id="ProjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="" id="frmAddProject"></div>
    </div>
</div>

<!-- Main Wrapper--> 
<!-- footer-->
<div class="container-fluid footer no-print">
  <div class="row">
    <div class="col-lg-12"> Copyright &copy; 2016 - Maxer Online. All Rights Reserved. </div>
  </div>
</div>
<!--footer--> 


<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/validator/bootstrapValidator.min.js') }}"></script>
<script src="{{ asset('assets/chosen/chosen.jquery.js?v=1.0') }}"></script>
<script type="text/javascript" src="{{ asset('assets/select2/js/select2.full.min.js?v=1.0') }}"></script>
<script src="{{ asset('assets/sweetalert2/dist/sweetalert2.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/accounting.min.js?v=1.0') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/custom.js')}}"></script>

<script type='text/javascript'>
/* <![CDATA[ */
var ERP_AC = {"nonce":"ba48391130","emailConfirm":"Sent","emailConfirmMsg":"The email has been sent","confirmMsg":"You are about to permanently delete this item.","copied":"Copied","ajaxurl":"","decimal_separator":".","thousand_separator":",","number_decimal":"2","currency":"","symbol":"$","message":{"confirm":"Are you sure!","new_customer":"New Customer","new_vendor":"New Vendor","new":"Create New","transaction":"Transaction History","processing":"Processing please wait!","new_tax":"Tax Rates","tax_item":"Tax item details","tax_update":"Tax Update","tax_deleted":"Your tax record has been deleted successfully","delete":"Are you sure you want to delete this? This cannot be undone.","void":"Are you sure you want to mark this transaction as void? This action can not be reversed!","restore":"Yes, restore it!","cancel":"Cancel","error":"Error!","alreadyExist":"Already exists as a customer or vendor","transaction_status":"Transaction Status","submit":"Submit","redo":"Yes, redo it!","yes":"Yes, do it!","no_result":"No Result Found!","search":"Search"},"plupload":{"url":"","flash_swf_url":"","filters":[{"title":"Allowed Files","extensions":"*"}],"multipart":true,"urlstream_upload":true}};
/* ]]> */
</script>
<script type="text/javascript" src="{{ asset('assets/js/erp-accounting.js?v=1.0') }}"></script>


<!-- select option -->
<script>
$(document).ready(function() {

  // Default dropdown action to show/hide dropdown content
  $('.js-dropp-action').click(function(e) {
    e.preventDefault();
    $(this).toggleClass('js-open');
    $(this).parent().next('.dropp-body').toggleClass('js-open');
  });

  // Using as fake input select dropdown
  $('label').click(function() {
    $(this).addClass('js-open').siblings().removeClass('js-open');
    $('.dropp-body,.js-dropp-action').removeClass('js-open');
  });
  // get the value of checked input radio and display as dropp title
  $('input[name="dropp"]').change(function() {
    var value = $("input[name='dropp']:checked").val();
    $('.js-value').text(value);
  });

});
</script>

<script type="text/javascript">
    $(document).ready(function() {
    $('#list').click(function(event){event.preventDefault();$('#products .item').addClass('list-group-item');});
    $('#grid').click(function(event){event.preventDefault();$('#products .item').removeClass('list-group-item');$('#products .item').addClass('grid-group-item');});
});
</script>
<!-- select option -->

<!--clander-->
<link rel="stylesheet" href="{{ asset('assets/css/monthly.css') }}">
 
    <script type="text/javascript" src="{{ asset('assets/js/monthly.js') }}"></script>
    <script type="text/javascript">
        $(window).load( function() {
    
            $('#mycalendar').monthly({
                mode: 'event',
                //jsonUrl: 'events.json',
                //dataType: 'json'
                xmlUrl: 'events.xml'
            });
        });
    </script>
<!-- clander-->




<script type="text/javascript" src="{{ asset('assets/js/jquery.canvasjs.min.js') }}"></script>
<script type="text/javascript">
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      theme: "theme1",
      title:{
        text: "Month"
      },
      animationEnabled: true,
      axisX: {
        valueFormatString: "MMM",
        interval:1,
        intervalType: "month"
        
      },
      axisY:{
        includeZero: false
        
      },
      data: [
      {        
        type: "line",
        //lineThickness: 3,        
        dataPoints: [
        { x: new Date(2012, 00, 1), y: 450 },
        { x: new Date(2012, 01, 1), y: 414},
        { x: new Date(2012, 02, 1), y: 520, indexLabel: "highest",markerColor: "red", markerType: "triangle"},
        { x: new Date(2012, 03, 1), y: 460 },
        { x: new Date(2012, 04, 1), y: 450 },
        { x: new Date(2012, 05, 1), y: 500 },
        { x: new Date(2012, 06, 1), y: 480 },
        { x: new Date(2012, 07, 1), y: 480 },
        { x: new Date(2012, 08, 1), y: 410 , indexLabel: "lowest",markerColor: "DarkSlateGrey", markerType: "cross"},
        { x: new Date(2012, 09, 1), y: 500 },
        { x: new Date(2012, 10, 1), y: 480 },
        { x: new Date(2012, 11, 1), y: 510 }
        
        ]
      }
      
      
      ]
    });

chart.render();
}
</script>

@yield('scripts')
</body>
</html>
