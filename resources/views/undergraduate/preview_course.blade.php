@extends('layouts.main')
@section('title','Preview Course ')
@section('content')
<div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
         
                    "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong></h1>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">Preview Course </li>
                        </ul>
                    </div><!--//breadcrumbs-->
                </header> 
                </div>
                <div class="row" style="margin-bottom: 20px;">
                <div class="table-responsive col-sm-12 col-md-10 col-md-offset-1">
                 {{! $next_ss = $ss+1}}
                <p><b>Session :</b>{{$ss." / ".$next_ss }} </p>
                 <p><b>Level :</b>{{$l}}00 </p>
                  <p><b>Semeter :</b>
                 @if(Auth::user()->programme_id == 4)
                  @if($s == 1)
              Contact 1
                  @elseif($s == 2)
                Contact 2
                  @endif
                 @else
                  @if($s == 1)
                  First 
                  @elseif($s == 2)
                  Second
                  @endif
                  @endif
                  </p>
                @if(isset($pre))
                 @if(count($pre) > 0)
                 @if($pre->sum('reg_course_unit') > $cu->max)
                      <div class=" col-sm-10 col-sm-offset-1 alert alert-danger" role="alert">
     Total number of course unit  select is above {{$cu->max}} units . maximum course unit for these semester.
     Contact your <strong> examination Officer </strong> if you need more clerification.
     <br/> <br/>
     <a href="{{url('register_course')}}" class="btn"><i class="fa fa-btn fa-arrow-circle-left"></i> Go Back </a>
    </div> 
                 @elseif($pre->sum('reg_course_unit') < $cu->min)
                      <div class=" col-sm-10 col-sm-offset-1 alert alert-danger" role="alert">
     Minimum course unit allowed is {{$cu->min}} units.
     Contact your <strong> examination Officer </strong> if you need more clerification.
     <br/> <br/>
     <a href="{{url('register_course')}}" class="btn"><i class="fa fa-btn fa-arrow-circle-left"></i> Go Back </a>
    </div> 
                 @else
                       <form class="form-horizontal" role="form" method="POST" action="{{ url('/register_course') }}" data-parsley-validate>
                        {{ csrf_field() }}

          
                              
                                    <table class="table table-boxed">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                          
                                                <th>Title</th>
                                                <th>Code</th>
                                                <th>Unit</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          {{!!$c = 0}}
                                        @foreach($pre as $v)
                                             {{!++$c}}
                                            @if(($c % 2)== 0)
                                            <tr>
                                            @else
                                            <tr class='danger'>
                                            @endif
                                                <td>{{$c}}</td>
                                                <input type="hidden" name="id[]" value="{{$v['id']}}">
                                                <input type="hidden" name="level" value="{{$l}}">
                                                <input type="hidden" name="semester" value="{{$s}}">

                                                 <td>{{strtoupper($v->reg_course_title)}}</td>
                                                <td>{{strtoupper($v->reg_course_code)}}</td>
                                                  <td>{{$v->reg_course_unit}}</td>
                                                <td>{{$v->reg_course_status}}</td>
                                            </tr>
                                         @endforeach 
                                         <tr>  
                                           <td colspan="3">Total Unit</td>
                                                <td colspan="2">{{$pre->sum('reg_course_unit')}} Unit</td>
                                            </tr> 
                                        </tbody>
                                    </table><!--//table-->
                           
                                  <div class="col-xs-6 col-sm-3 col-sm-offset-1">
                                   
                                <a href="{{url('register_course')}}" class="btn ">
                                    <i class="fa fa-btn fa-arrow-circle-left"></i> Go Back
                                </a>
                            </div>

                           <div class="col-xs-6 col-sm-offset-5 col-sm-3">
                                   
                                <button type="submit" class="btn">
                                    <i class="fa fa-btn fa-user"></i> Register
                                </button>
                            </div>
                                </form>
                                @endif
                                @else
                         <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert">
     No course is avalable for registration in these session. please contact your examination Officer or send a message to us through mail.<br/>
     <strong>Thank you.... Unical exam portal Admin</strong>
    </div>       
                                @endif
                                 @endif
                                 </div>
                </div>
                </div>
@endsection