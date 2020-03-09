@extends('layouts.app')

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/profile.manage_profile')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('') }}">@lang('admin/dashboard.dashboard-heading')</a>  / <a href="javascript:void();" class="active">@lang('admin/profile.manage_profile')</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

<div class="profile_image" style="">

<div style="height: 200px;">
	<div class="slim" data-label="Drop your cover photo here" data-service="{{ url('/profile/cover') }}" data-ratio="14:3">
         @if($user->cover <> NULL && file_exists(storage_path().'/app/cover/'.$user->cover))
         	<img src="{{ asset('storage/app/cover/'.$user->cover) }}" alt="">
         @endif         
    	<input type="file" name="slim[]" required />
</div>
</div>
	
	<div class="container">
		<div class="col-sm-2 col-md-2 col-lg-2 col-xs-12 pull-right no-padding">
			<div class="col-sm-12 col-xs-12">
				<a href="" class="btn btn-danger btn-block new-btn zindex" data-toggle="modal" data-target="#myModal">@lang('admin/profile.edit_now_btn')</a>
			</div>
			<!-- Button trigger modal -->
			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">@lang('admin/profile.manage_profile')</h4>
			      </div>
			      <form data-toggle="validator" method="post" class="registration-form" action="{{ url('/profile/update') }}" enctype="multipart/form-data">
			      <div class="modal-body clearfix">
			      
			        <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
			        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			           
			            <div class="">
			              
			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
			                <label for="first_name" class="input_label">@lang('admin/profile.first_name_label')*</label>
			                <input type="text" name="first_name" id="first_name" class="form-control1" placeholder="@lang('admin/profile.first_name_label')*" required="required" value="{{$user->first_name}}" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding">
			                <label for="last_name" class="input_label">@lang('admin/profile.last_name_label')*</label>
			                <input type="text" name="last_name" id="last_name" class="form-control1" placeholder="@lang('admin/profile.last_name_label')*" required="required" value="{{$user->last_name}}" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
			                <label for="password" class="input_label">@lang('admin/profile.password_label')*</label>
			                <input type="password" name="password" id="password" class="form-control1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" data-bv-identical-field="password_confirmation" placeholder="@lang('admin/profile.password_label')*" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding">
			                <label for="password_confirmation" class="input_label">@lang('admin/profile.cpassword_label')*</label>
			                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control1" placeholder="@lang('admin/profile.cpassword_label')*" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" data-bv-identical-field="password" data-bv-identical="true" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
			                <label for="fathers_name" class="input_label">@lang('admin/profile.fathers_name_label')</label>
			                <input type="text" name="fathers_name" id="fathers_name" class="form-control1" placeholder="@lang('admin/profile.fathers_name_label')" value="{{$user->fathers_name}}" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 col-xs-6 form-group no-padding">
			                <label for="mothers_name" class="input_label">@lang('admin/profile.mothers_name_label')</label>
			                <input type="text" name="mothers_name" id="mothers_name" class="form-control1" placeholder="@lang('admin/profile.mothers_name_label')" value="{{$user->mothers_name}}" />
			              </div>

			              
			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
			                <label for="country_id" class="input_label">@lang('admin/profile.nationality_label')*</label>
			                <select name="country_id" id="country_id" class="form-control1" required="required">
			                	<option value="">@lang('admin/profile.select_option')</option>
			                	@if(isset($countries) && count($countries) > 0)
									@foreach($countries as $country)
										@if($country->id == $user->nationality)
											<option value="{{ $country->id }}" selected="selected">{{ $country->country_name }}</option>
										@else
											<option value="{{ $country->id }}">{{ $country->country_name }}</option>
										@endif
									@endforeach
			                	@endif
			                </select>

			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 col-xs-6 form-group no-padding">
			                <label for="email" class="input_label">@lang('admin/profile.email_label')*</label>
			                <input type="text" name="email" id="email" class="form-control1" placeholder="@lang('admin/profile.email_label')*" required="required" value="{{ $user->email }}" data-bv-emailaddress-message="The input is not a valid email address" data-bv-emailaddress="true" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 col-xs-6 form-group no-padding-left">
			                <label for="phone_no" class="input_label">@lang('admin/profile.phone_no_label')*</label>
			                <input type="text" name="phone_no" id="phone_no" class="form-control1" placeholder="@lang('admin/profile.phone_no_label')*" required="required" value="{{ $user->phone_no }}" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 col-xs-6 form-group no-padding">
			                <label for="mobile_no" class="input_label">@lang('admin/profile.mobile_no_label')*</label>
			                <input type="text" name="mobile_no" id="mobile_no" class="form-control1" placeholder="@lang('admin/profile.mobile_no_label')" value="{{ $user->mobile_no }}" />
			              </div>


			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 col-xs-6 form-group no-padding-left">
			                <label for="present_address" class="input_label">@lang('admin/profile.present_address_label')*</label>
			                <input type="text" name="present_address" id="present_address" class="form-control1" placeholder="@lang('admin/profile.present_address_label')*" required="required" value="{{ $user->present_address }}" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 col-xs-6 form-group no-padding">
			                <label for="permanant_address" class="input_label">@lang('admin/profile.permanant_address_label')</label>
			                <input type="text" name="permanant_address" id="permanant_address" class="form-control1" placeholder="@lang('admin/profile.permanant_address_label')" value="{{ $user->permanant_address }}" />
			              </div>


			            </div>
        
      				</div>
			      </div>
			      <div class="modal-footer">
			        <input type="submit" class="btn btn-primary" value="@lang('admin/profile.submit_btn')">
			      </div>

			      </form>

			    </div>
			  </div>
			</div>
			<div class="col-sm-7 col-xs-7 no-padding-right">

				<input type="file" name="cover[{{$user->id}}]" id="imgupload" style="display:none"/>
			</div>
		</div>
	</div>
	
	
</div>

<div class="container mainwrapper margin-top">
	<div class="row">
		<div class="col-sm-4 col-lg-4 col-xs-12 col-md-4">
			<div class="avatar_area text-center">
				<div class="profile-avatar">
					
					<div class="avatar droper">

					    <div class="slim"
					         data-label="Drop your avatar here"
					         data-size="240,240"
					         data-service="{{ url('/profile/ajax') }}"
					         data-meta-user-id="{{$user->id}}"
					         data-ratio="1:1"
					         data-load="isHotEnough">
					         @if($user->avatar <> NULL && file_exists(storage_path().'/app/avatar/'.$user->avatar))
					         	<img src="{{ asset('storage/app/avatar/'.$user->avatar) }}" alt="">
					         @endif
					         
					        <input type="file" name="slim[]" required />
					    </div>

					</div>

					<script type="text/javascript">
						function isHotEnough()
						{
							alert(3);
						}
					</script>

					
					<h2>{{ $user->first_name }} {{ $user->last_name }}</h2>
					<p>{{ $user->roles->title }}</p>
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
			    <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">@lang('admin/profile.profile_tab') <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
			    <li role="presentation"><a href="#notice" aria-controls="notice" role="tab" data-toggle="tab">@lang('admin/profile.notice_board_tab') <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
			    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">@lang('admin/profile.conversation_tab') <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
			    
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="profile">
			    	<div class="row">
                          
                          <div class="col-sm-12 block no-padding top-margin-space">
                            <div class="col-sm-4">
                              <div class="area-heading"><h2>@lang('employees/common.personal_detail')</h2></div>
                              <div class="detail_area">
                                <h3>{{ $user->first_name }} {{ $user->last_name }} </h3>
                                <p></p>

                                <h2>@lang('employees/common.nationality_txt')</h2>
                                <p> {{ $user->countries->country_name }} </p>

                                
                              </div>
                            </div>
                            <div class="col-sm-4">
                              
                              <div class="detail_area">
                                <h1>@lang('employees/common.contact_detail_txt')</h1>
                                <p><b>@lang('employees/common.email_txt'):</b> {{ $user->email }}</p>
                                <p><b>@lang('employees/common.phone_no_txt'):</b> {{ $user->phone_number }}</p>

                                <h2>@lang('employees/common.present_address_txt')</h2>
                                <p>{{ $user->present_address }}</p>

                                <h2>@lang('employees/common.permanant_address_txt')</h2>
                                <p>{{ $user->permanant_address }}</p>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              
                              <div class="detail_area">
                                <h1>@lang('employees/common.login_detail_txt') </h1>
                                <p><b>@lang('employees/common.username_txt')</b>  {{ $user->username }}</p>
                                <p><b>@lang('employees/common.userpass_txt') </b> ****** </p>

                   
                              </div>
                             
                            </div>
                          </div>


                          

                        </div>
			    	{{-- <div class="tab-block">
			    		<table class="table table-bordered table-striped">

			    			<tr>
			    				<td colspan="2" class="block-heading"><h2> @lang('admin/profile.personal_detail_txt')</h2></td>
			    			</tr>
							<tr>
								<td><strong>@lang('admin/profile.name_txt')</strong></td>
								<td><strong>@lang('admin/profile.email_txt')</strong></td>
					
							</tr>
							<tr>
								<td>{{ $user->first_name }} {{ $user->last_name }}</td>
								<td>{{ $user->email }}</td>
								
							</tr>
							<tr>
								<td><strong>@lang('admin/profile.last_login_date_txt')</strong></td>
								<td><strong>@lang('admin/profile.last_login_ip_txt')</strong></td>
						
							</tr>
							
							<tr>
								<td>{{ $user->last_login }}</td>
								<td>{{ $user->login_ip }}</td>
						
							</tr>

						</table>
			    	</div> --}}
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
                          <td colspan="12" style="border: 1px solid #fff;">
                              <div class="accordian-body collapse" id="nt{{$notice['sr']}}"> 
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
                                </div> 
                            </td>
                      		</tr>
                          	</tbody>

                          	@endforeach

                          @else

                          	<tr>
                          		<td colspan="4">@lang('admin/common.notfound')</td>
                          	</tr>
                          @endif
                      </table>
                      </div>
                  
                    </div> 
                  
                </div>

			    </div>
			    <div role="tabpanel" class="tab-pane" id="messages">...b</div>
			  </div>

			</div> 
		</div>
	</div>
</div>


@endsection

@section('scripts')

<link rel="stylesheet" href="{{ asset('assets/slim/slim.min.css')}}">
<script type="text/javascript" src="{{ asset('assets/slim/slim.commonjs.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/slim/slim.amd.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/slim/slim.global.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/slim/slim.kickstart.min.js')}}"></script>

<style type="text/css">
	.avatar .slim {
	    /*width: 240px;*/
	    border-radius: 50%;
	}
	
</style>

<script>
function isHotEnough(file, image, meta) {
   console.log(file);
}
</script>


  <script type='text/javascript'>
   

    $(document).ready(function (){
     
      $('form[data-toggle="validator"]').bootstrapValidator({
        excluded: [':disabled'],
      }).on('status.field.bv', function(e, data) {
        data.element.data('bv.messages').find('.help-block[data-bv-for="' + data.field + '"]').hide();
      });

    });

  </script>

@endsection