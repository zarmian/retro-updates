@extends('layouts.app')

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/profile.manage_profile')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
      <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
      <a href="javascript:void();" class="active">@lang('admin/profile.manage_profile')</a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('assets/slim/slim.min.css')}}">
<style type="text/css">
    .avatar .slim {
        /*width: 240px;*/
        border-radius: 50%;
    }
    
</style>

<div style="height: 200px;">
 @if($user->cover <> NULL && file_exists(storage_path().'/app/employees/covers/'.$user->cover))
     
<div class="profile_image" style="background: url('{{ asset('storage/app/employees/covers/'.$user->cover) }}'); background-size: 100% 100%;"></div>
@else

<div class="profile_image" style="background: url('{{ asset('storage/app/employees/covers/bg-solid-dark-grey.png') }}'); background-size: 100% 100%;"></div>
@endif 

</div>

<div class="margin-top">&nbsp;</div>
<div class="margin-top">&nbsp;</div>
<div class="container mainwrapper margin-top">
    <div class="row">
        <div class="col-sm-4 col-lg-4 col-xs-12 col-md-4">
            <div class="avatar_area text-center">
                <div class="profile-avatar">
                    <div class="avatar droper">
                         @if($user->avatar <> NULL && file_exists(storage_path().'/app/employees/avatars/'.$user->avatar))
                            <img src="{{ asset('storage/app/employees/avatars/'.$user->avatar) }}" alt="">
                          @else
                          <img src="{{ asset('storage/app/employees/avatars/img-person.jpg') }}" alt="">
                         @endif
                    </div>
                    <h2>{{ $user->first_name }} {{ $user->last_name }}</h2>
                    <p><b>@lang('employees/common.department_txt') </b> {{ $user->department->title }}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-8 col-lg-8 col-xs-12 col-md-8">

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
            
            <div>

              <!-- Nav tabs -->
              <ul class="nav nav-tabs profile-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">@lang('employees/common.profile_tab') <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
                <li role="presentation"><a href="#account" aria-controls="notice" role="tab" data-toggle="tab">@lang('employees/common.profile_accounts_tab') <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
                <li role="presentation"><a href="#qdetaul" aria-controls="notice" role="tab" data-toggle="tab">@lang('employees/common.profile_qualification_tab') <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
                <li role="presentation"><a href="#exptab" aria-controls="notice" role="tab" data-toggle="tab">@lang('employees/common.profile_experience_tab') <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
                <li role="presentation"><a href="#attendance" aria-controls="attendance" role="tab" data-toggle="tab">@lang('admin/profile.attendance_tab') <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
                <li role="presentation"><a href="#notice" aria-controls="notice" role="tab" data-toggle="tab">@lang('admin/profile.notice_board_tab') <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="profile">
                    <div>

                        <div class="row">
                          
                          <div class="col-sm-12 block no-padding top-margin-space">
                            <div class="col-sm-4">
                              <div class="area-heading"><h2>@lang('employees/common.personal_detail')</h2></div>
                              <div class="detail_area">
                                <h3>{{ $user->first_name }} {{ $user->last_name }} <span class="circle-box pull-right"><i class="fa fa-{{ strtolower($user->genders->title) }}"></i></span></h3>
                                <p>({{ $user->department->title }})</p>
                                <p>@lang('employees/common.dob_txt') {{ date('d M, Y', strtotime($user->date_of_birth)) }}</p>

                                <h2>@lang('employees/common.nationality_txt') {{ $user->countries->country_name}}</h2>
                                <p><b>@lang('employees/common.national_id_txt'):</b> {{ $user->national_id }}</p>
                                <p><b>@lang('employees/common.country_txt'):</b> </p>

                                <h2>@lang('employees/common.parents_txt')</h2>
                                <p><b>@lang('employees/common.fathers_name_txt'):</b> {{ $user->fathers_name }}</p>
                                <p><b>@lang('employees/common.mothers_name_txt'):</b> {{ $user->mothers_name }}</p>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              
                              <div class="detail_area">
                                <h2>@lang('employees/common.contact_detail_txt')</h2>
                                <p><b>@lang('employees/common.email_txt'):</b> {{ $user->email }}</p>
                                <p><b>@lang('employees/common.phone_no_txt'):</b> {{ $user->phone_no }}</p>

                                <h2>@lang('employees/common.present_address_txt')</h2>
                                <p>{{ $user->present_address }}</p>

                                <h2>@lang('employees/common.permanant_address_txt')</h2>
                                <p>{{ $user->permanant_address }}</p>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              
                              <div class="detail_area">
                                <h2>@lang('employees/common.login_detail_txt') </h2>
                                <p><b>@lang('employees/common.username_txt')</b>  {{ $user->username }}</p>
                                <p><b>@lang('employees/common.userpass_txt') </b> ****** </p>

                                <h2><b>@lang('employees/common.joining_date_txt')</b></h2>
                                <p>{{ date('d M, Y', strtotime($user->joining_date)) }}</p>

                                
                                <h2>@lang('employees/common.shift_txt')</h2>
                                <p>{{$user->shift->title}}</p>
                                <p>{{ date('h:i:s', strtotime($user->shift->start_time))}} to {{ date('h:i:s', strtotime($user->shift->end_time)) }}</p>
                                <p>Off Days: Sat, Sun</p>
                              </div>

                            </div>
                          </div>


                          <div class="col-sm-12 block no-padding top-margin-space">
                            <div class="col-sm-4">
                              <div class="area-heading">
                                <h2>@lang('employees/common.salary_detail_txt')</h2>
                              </div>

                              <div class="detail_area">
                                  <h1 class="net_cash">@lang('employees/common.basic_txt') {{ number_format($user->basic_salary, 2) }} <span class="currency">{{ $currency }}</span> </h1>
                                  <h2>@lang('employees/common.allowance_txt')</h2>
                                  
                                  <p><b>@lang('employees/common.accomodation_allowance_txt')</b> {{ number_format($user->accomodation_allowance, 2) }} {{ $currency }}</p>
                                  <p><b>@lang('employees/common.medical_allowance_txt')</b> {{ number_format($user->medical_allowance, 2) }} {{ $currency }}</p>
                                  <p><b>@lang('employees/common.food_allowance_txt')</b> {{ number_format($user->food_allowance, 2) }} {{ $currency }}</p>

                                  <h1 class="net_cash"><b>@lang('employees/common.net_cash_txt')</b> {{ number_format($user->basic_salary + $user->accomodation_allowance + $user->medical_allowance + $user->food_allowance + $user->house_rent_allowance + $user->transportation_allowance, 2) }} {{ $currency }}</h1>

                                </div>
                            </div>
                              <div class="col-sm-4">

                              <div class="detail_area">

                                <div class="detail_box">
                                  
                                  <p><b>@lang('employees/common.house_txt') </b> {{ number_format($user->house_rent_allowance, 2) }} {{ $currency }}</p>
                                  <p><b>@lang('employees/common.transportation_allowance_txt') </b> {{ number_format($user->transportation_allowance, 2) }} {{ $currency }}</p>
                                </div>

                                </div>
                                
                              </div>

                              <div class="col-sm-4">

                              <div class="detail_area">

                                <h2 class="basic">@lang('employees/common.overtime_txt')</h2>
                                  <p><b>@lang('employees/common.overtime_1_txt')</b> {{ $user->overtime_1 }}</p>
                                  <p><b>@lang('employees/common.overtime_2_txt')</b> {{ $user->overtime_2 }}</p>
                                  <p><b>@lang('employees/common.overtime_3_txt')</b> {{ $user->overtime_3 }}</p>
                                </div>
                                
                              </div>


                            
                            
                          </div>

                        </div>
                        
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="account">
                    <div class="">

                        <div class="row">
                          <div class="account_block">
                            <div class="col-sm-4 no-padding">
                              <div class="collection_box bg-color-pink">
                                <h1>{{ $total_received }} <span class="currency">{{ $currency }}</span></h1>
                                <span>@lang('admin/employees.total_receive_txt')</span>
                              </div>
                            </div>
                            <div class="col-sm-4 no-padding">
                              <div class="collection_box bg-color-orange">
                                <h1>{{ $total_ded }} <span class="currency">{{ $currency }}</span></h1>
                                <span>@lang('admin/employees.total_deduction_txt')</span>
                              </div>
                            </div>
                            <div class="col-sm-4 no-padding">
                              <div class="collection_box bg-color-seagreen">
                                <h1>{{ $total_loan }} <span class="currency">{{ $currency }}</span></h1>
                                <span>@lang('admin/employees.total_loan_received')</span>
                              </div>
                            </div>
                          </div>

                          @if(isset($salaries) && count($salaries) > 0)

                          <div class="col-sm-12 no-padding record-heading"><h4><b>@lang('admin/employees.prevous_month_txt')</b></h4></div>
                          

                          @foreach($salaries as $salary)
                          <div class="col-lg-4 col-sm-6 col-md-4 col-xs-12 no-padding">
                            <div class="accounts_box">
                              <h6><b>@lang('employees/common.salary_of_txt') {{ $salary['date'] }}</b> <span class="salary-status"><b>{{ $salary['status'] }}</b></span></h6>
                              <div class="education_detail">
                                <span>@lang('employees/common.total_salary_txt'): <b>{{ $salary['total'] }} {{ $currency }}</b></span><br>
                                <span>@lang('employees/common.deduction_txt'): <b>{{ $salary['deduction'] }} {{ $currency }}</b></span><br>
                                <span class="received_amount color-red">@lang('employees/common.received_txt'): <b>{{ $salary['received'] }} {{ $currency }}</b> </span><br> 
                                
                              </div>
                            </div>
                          </div>
                          @endforeach

                          @endif



                        </div>
  

                        
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="qdetaul">

                @if(isset($qualifications) && count($qualifications) > 0)

                    <div class="row">
                      <div class="col-sm-12"><h4><b>@lang('employees/common.education_heading_txt')</b></h4></div>
                      <div class="tab-block">

                        @foreach($qualifications as $qualification)
                          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="education_box">
                              <h6><b>{{ $qualification->degree_name }}</b> <span class="grade-status"><b>{{ $qualification->grade }}</b></span></h6>
                              <div class="education_detail">
                                <span>@lang('employees/common.from_institue_txt') <b>{{ $qualification->institute }}@if(isset($qualification->eCountry->country_name) && $qualification->eCountry->country_name <> "") , {{ $qualification->eCountry->country_name }} @endif </b></span><br>
                                <span>@lang('employees/common.institue_year') <b>{{ $qualification->year }}</b> </span><br>
                                <span>@lang('employees/common.total_marks_txt') <b>{{ $qualification->total_marks }}</b> </span> 
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                <span>@lang('employees/common.obtain_marks_txt') <b>{{ $qualification->obtain_marks }}</b></span>
                              </div>
                            </div>
                          </div>
                        @endforeach

                          
                      </div>


                    </div>

                    @endif
                </div>


                <div role="tabpanel" class="tab-pane" id="exptab">

                @if(isset($experiences) && count($experiences) > 0)

                    <div class="row">
                      <div class="col-sm-12"><h4><b>@lang('employees/common.experience_heading_txt')</b></h4></div>
                      <div class="tab-block">

                        @foreach($experiences as $experience)
                          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="education_box">
                              <h6><b>{{ $experience->job_title }}</b></h6>
                              <div class="education_detail">
                                <span>@lang('employees/common.from_institue_txt') <b>{{ $experience->company_name }} @if(isset($experience->eCountry->country_name) && $qualification->eCountry->country_name <> "") , {{ $qualification->eCountry->country_name }} @endif </b></span><br>
                                <span>@lang('employees/common.institue_year') <b>{{ $experience->start_date }}</b> TO <b>{{ $experience->end_date }}</b> </span>
                              </div>
                            </div>
                          </div>
                        @endforeach

                          
                      </div>


                    </div>

                    @endif
                </div>

                

                <div role="tabpanel" class="tab-pane" id="attendance">
                  <div class="panel panel-default">

                  @if(isset($attendences) && count($attendences) > 0)
                    <div class="panel-body">
                      <h3>@lang('employees/common.att_of_txt') {{ $attendences[0]['head_date'] }}</h3>
                    </div>

                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th align="center" class="text-center">#</th>
                            <th align="left" class="text-left">@lang('employees/common.date_txt')</th>
                            <th align="left" class="text-left">@lang('employees/common.closing_detail_txt')</th>
                            <th align="center" class="text-center">@lang('employees/common.t_in_txt')</th>
                            <th align="center" class="text-center">@lang('employees/common.t_out_txt')</th>
                            <th class="color-red text-center">@lang('employees/common.t_short_txt')</th>
                          </tr>
                        </thead>

                        <tbody>
                        @foreach($attendences as $attendance)
                          <tr>
                            <td align="center">{{ $attendance['sr'] }}</td>
                            <td align="left">{{ $attendance['date'] }}</td>
                            <td align="center">{{ $attendance['in_time'] }}</td>
                            <td align="center">{{ $attendance['out_time'] }}</td>
                            <td align="left"><a href="#" data-toggle="modal" data-detail="{!! $attendance['detail'] !!}" data-target="#detailModal">{{ Str::limit($attendance['detail'], 10) }}</a> </td>
                            <td align="center" class="color-red text-center">{!! $attendance['t_short'] !!}</td>
                          </tr>

                          @endforeach

                        </tbody>
                      </table>

                      @endif
                    
                  </div>
                </div>
                
                <div role="tabpanel" class="tab-pane" id="notice">
                    

                  <div class="col-lg-12">

                    <div class="panel panel-default">
                      <div class="panel-heading">@lang('employees/common.notification_txt')</div>
                      <div class="panel-body">
                      <table class="table table-condensed" style="border-collapse:collapse;">

                      @if(isset($notices) && count($notices) > 0)

                        @foreach($notices as $notice)
                          <thead>
                              <tr>
                                  <th>&nbsp;</th>
                                  <th>@lang('employees/common.simple_date_txt')</th>
                                  <th>@lang('employees/common.title_txt')</th>
                              </tr>
                          </thead>

                          <tbody>
                              <tr data-toggle="collapse" data-target="#nt{{$notice['sr']}}" class="accordion-toggle">
                                  <td><button class="btn btn-default btn-xs"><span class="fa fa-eye"></span></button></td>
                                  <td>{{ $notice['datetime'] }}</td>
                                  <td>{{ $notice['title'] }}</td>
                              </tr>
                              <tr>
                                  <td colspan="12" style="border: 1px solid #fff;"><div class="accordian-body collapse" id="nt{{$notice['sr']}}"> 
                                    <table class="table table-striped">
                                            <thead>
                                             <tr>
                                               <th>@lang('employees/common.notification_des_txt')</th>
                                             </tr>
                                              
                                            </thead>
                                            <tbody>
                                          
                                              <tr>
                                                <td>{!! $notice['description'] !!}</td>
                                              </tr>
                                           
                                          
                                            </tbody>
                                      </table>
                                    
                                    </div> </td>
                              </tr>

                            
                          </tbody>

                          @endforeach
                          @endif
                      </table>
                      </div>
                  
                    </div> 
                  
                </div>


                </div>
              </div>

            </div> 
        </div>
    </div>
</div>

<!-- Modal -->
<div id="detailModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">@lang('admin/shift.today_activity_txt')</h4>
      </div>
      <div class="modal-body">
        <p>@lang('admin/shift.wait_txt')</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection
@section('scripts')
  <script type="text/javascript">

    $('#detailModal').on('show.bs.modal', function (event) {

      var button = $(event.relatedTarget); // Button that triggered the modal
      var detail = button.data('detail'); // Extract info from data-* attributes
      $('.modal-body').html(detail);
      
    });

    $('.datepicker').dateDropper();
    $(".chosen").select2();
  </script>
@endsection