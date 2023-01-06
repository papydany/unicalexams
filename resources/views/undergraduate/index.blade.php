@extends('layouts.main')
@section('title','Home')
@section('content')
<div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h4 class="heading-title pull-left"><strong class="">{{ strtoupper(Auth::user()->surname
                    .' '.Auth::user()->firstname." ".Auth::user()->othername )}}  </strong>
                    &nbsp;&nbsp;
                    <strong class="text-primary">{{Auth::user()->matric_number}}</strong></h4>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">Undergraduate</li>
                        </ul>
                    </div><!--//breadcrumbs-->
                 
                </header> 
                
    
                <div class="page-content">                 
                    <div class="row page-row">                     
                        <div class="team-wrapper col-xs-12" style="padding: 0px;">        
                            <div class="row page-row" >
                            <div class="col-sm-6">    
                             <div class="col-sm-12 table-responsive">
                              <a href="{{url('moppedUpExamsCourseRegistration')}}" class="btn btn-danger btn-block" style="background-color:red !important;font-weight:bolder">Click To  Register For Mopped Up Examination</a>
                         <br/><br/>
                              <table class="table table-bordered table-striped">
                            <tr>
                              <th class="text-primary">Matric Number </th>
                              <th>{{Auth::user()->matric_number}}</th>
                            </tr>
                            <tr>
                              <th class="text-primary">Programme</th>
                              <th>{{$p->programme_name}}</th>
                            </tr>
                            <tr>
                              <th class="text-primary">Faculty</th>
                              <th>{{$f->faculty_name}}</th>
                            </tr>
                            <tr>
                              <th class="text-primary">Department</th>
                              <th>{{$d->department_name}}</th>
                            </tr>
                            <tr>
                              <th class="text-primary">Field of Study</th>
                              <th>{{$fs->fos_name}}</th>
                            </tr>
                            @if(Auth::user()->specialization_id != 0 || Auth::user()->specialization_id != null)
                            <tr>
                              <th class="text-primary">Specialization</th>
                              <th>{{$spec->name}}</th>
                            </tr>

                            @endif
                            <tr>
                              <th class="text-primary">Phone Number</th>
                              <th>{{Auth::user()->phone}}</th>
                            </tr>
                             <tr>
                              <th class="text-primary">Email</th>
                              <th>{{Auth::user()->email}}</th>
                            </tr>
                             <tr>
                              <th class="text-primary">Entry year</th>
                              <th>{{Auth::user()->entry_year}}</th>
                            </tr>

                          </table>
                         </div>
                        
                
                        <!--  <div class=" col-sm-12 thumbnail">
                          <h3 class="text-primary"><b><u> Update Password</u></b></h3>
                          <form class="form-horizontal " role="form" method="POST" action="{{ url('/updatePassword') }}" data-parsley-validate> 
                               {{ csrf_field() }}  	
                           
                               
                              	     <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                          

                         

                               <div class="col-sm-6">
                            <label for="matric_number">Enter Password</label>
                                <input  type="text" class="form-control" name="password" value="" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-6">
                            <br/>
                            	<input type="submit" name="" value="Update Password" class="btn">
                            </div>
                            </div>
                            
                        </form>
                          </div>-->
                        
                          <div class="col-sm-12 col-xm-12 thumbnail">
                          <h3 class="text-primary"><b><u> Update Email Address</u></b></h3>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('edit_email') }}" data-parsley-validate> 
                               {{ csrf_field() }}  	
                            	
                                
                              	     <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                          

                         

                               <div class="col-sm-6">
                            <label for="matric_number">Enter Email Address</label>
                                <input  type="email" class="form-control" name="email" value="" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-6">
                            <br/>
                            	<input type="submit" name="" value="Update Email Address" class="btn">
                            </div>
                            </div>
                           
                        </form>
                          </div>
                          <div class="col-sm-12 thumbnail">
                          <h3 class="text-primary"><b><u> Update Phone Number</u></b></h3>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('edit_phone_number') }}" data-parsley-validate> 
                               {{ csrf_field() }}  	
                            
                                
                              	     <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                          

                         

                               <div class="col-sm-6">
                            <label for="matric_number">Enter Phone</label>
                                <input  type="number" class="form-control" name="phone" value="" required>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-6">
                            <br/>
                            	<input type="submit" name="" value="Update phone number" class="btn">
                            </div>
                            </div>
                            
                        </form>
                          </div>
                        </div>
                        
                           <div class="col-md-6">
                             <div class="col-sm-12">
                              <img class="img-responsive" src="{{asset('img/student/'.Auth::user()->image_url)}}" alt="your image is suppose to display here" style="float: right;"/>
                              <a href="{{url('edit_image')}}" class="btn">Edit Image</a>
                             </div>
 
                                <div class="col-sm-12">
                                  <h5 class="text-center text-primary" style="font-size: 1.2em;"><b><u>  COURSE REGISTRATION HISTORY</u></b></h5>
                                  <table class="table table-boxed table-responsive">
                                      <thead>
                                        <tr>
                                           <th>#</th>
                                           <th>Session</th>
                                           <th>level</th>
                                           <th>Semester</th>
                                           <th>Status</th>
                                       </tr>
                                   </thead>
                                  <tbody>
                                      {{!!$c = 0}}
                                      @foreach($allstudentreg as $vf)
                                      {{!++$c}}
                                      @if(($c % 2)== 0)
                                          <tr>
                                      @else
                                        <tr class='success'>
                                      @endif
                                      <td>{{$c}}</td>
                                      
                                      <td>{{strtoupper($vf->session)}}</td>
                                      <td>{{strtoupper($vf->level_id)}}</td>
                                      <td>@if($vf->semester == 1)
                                     First
                                          
                                      @else
                                      Second
                                          
                                      @endif</td>
                                      <td>{{$vf->season}}</td>
                                      </tr>
                                  @endforeach 
                                  </tbody>
                                  </table>
                                </div>
                                          
                                        
                              </div>                             
                            </div>
                            
                          
                        </div><!--//team-wrapper-->
                    
                </div><!--//page-content-->
            </div><!--//page--> 
        </div><!--//content-->
    </div><!--//wrapper-->

@endsection