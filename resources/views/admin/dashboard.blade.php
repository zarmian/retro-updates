@extends('layouts.app')
@section('head')
    <style type="text/css">
        
        body {
            font-family: 'Ubuntu', sans-serif;
            font-size: 15px;
            line-height: 22px;
            color: #4f4f4f;
            background-color: #4c3881;
        }

        .topWrapper {
            background: #fff;
        }

        .topWrapperMargin{
            margin-bottom: 70px;
        }

    </style>

    {{-- <link href="{{ asset('assets/chart/css/mdb.min.css') }}" rel="stylesheet"> --}}
@endsection
@section('content')
<div class="container mainwrapper" style="margin-top: 30px;">
        <div class="row">

            <div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="ibox ibox-content border-radius box-margin">
                          <canvas id="barChart" height="270"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <a href="{{ url('/leaves') }}">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="orang-mudim box-margin">
                                @lang('admin/common.manage_applications_txt')
                                <h3>@lang('admin/common.leaves_txt')<span class="dashboard-icon-size" style=""><i class="fa fa-calendar"></i></span></h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6">
                        <div class="orange box-margin">
                            <h3>{{ $departments }}</h3>@lang('admin/common.departments_heading')
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6">
                        <div class="light-orange box-margin">
                            <h3>{{ $employees }}</h3>@lang('admin/common.employees_heading')
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6">
                        <div class="purpal-light box-margin">
                            <h3>{{ $offical_leaves }}</h3>@lang('admin/common.holidays_heading')
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6">
                        <div class="red-light box-margin">
                            <h3>{{ $present_employees }}</h3>@lang('admin/common.present_employees_heading')
                        </div>
                    </div>
                </div>

                <div class="row">
                    <a href="{{ url('employees/ledger') }}">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="blue-mudim box-margin">@lang('admin/common.manage_employees_txt')
                                <h3>
                                    @lang('admin/common.ledger_txt')
                                    <span class="dashboard-icon-size" style="">
                                        <i class="fa fa-briefcase"></i>
                                    </span>
                                </h3>
                                
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
                <div style="width:100%; max-width:100%; display:inline-block;">
                    <div class="monthly" id="mycalendar"></div>
                </div>
            </div>

        </div>

        
    </div>
@endsection

@section('scripts')
<link href="{{ asset('assets/chart/css/style.css')}}" type="text/css" rel="stylesheet">

<script src="{{ asset('assets/chart/js/popper.min.js')}}"></script>
<script src="{{ asset('assets/chart/js/mdb.min.js')}}"></script>

<script type="text/javascript">
  //line
//bar
var ctxB = document.getElementById("barChart").getContext('2d');
var total_months = {!! json_encode($total_month) !!}
var total_amounts = {!! json_encode($schart) !!}
var myBarChart = new Chart(ctxB, {
    type: 'bar',
    data: {
        labels: total_months,
        datasets: [{
            label: 'Salary',
            data: total_amounts,
            backgroundColor: [
                'rgba(202, 255, 245, 1)',
                'rgba(202, 255, 245, 1)',
                'rgba(202, 255, 245, 1)',
                'rgba(202, 255, 245, 1)',
                'rgba(202, 255, 245, 1)',
                'rgba(202, 255, 245, 1)'
            ],
            borderColor: [
                'rgba(26,188,156,1)',
                'rgba(26,188,156,1)',
                'rgba(26,188,156,1)',
                'rgba(26,188,156,1)',
                'rgba(26,188,156,1)',
                'rgba(26,188,156,1)'
            ],
            borderWidth: 1
        }]
    },
    optionss: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

         
</script>

@endsection
