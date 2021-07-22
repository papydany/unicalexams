@extends('layouts.main')
@section('title','Preview Delete Course ')
@section('content')
<div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h4 class="text-center text-primary"><b><u>DELETE COURSES</u></b></h4>
                
                    <h4 class="heading-title pull-left"><strong class=''>{{ strtoupper(Auth::user()->surname.
             
                        " ". Auth::user()->firstname." ".Auth::user()->othername )}}</strong>
                        <strong class="text-primary">{{Auth::user()->matric_number}}</strong></h4>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">Delete Courses </li>
                        </ul>
                    </div><!--//breadcrumbs-->
                </header> 
                </div>
                <div class="row" style="margin-bottom: 20px;">
                <div class="table-responsive col-sm-12">
                 {{! $next_ss = $ss+1}}
                
                <h4><b>Session :</b>{{$ss." / ".$next_ss }} </h4>
                 <h4><b>Level :</b>{{$l}}00 </h4>
                  <h4><b>Semeter :</b>
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
                  </h4>
                @if(isset($pre))
                 @if(count($pre) > 0)
    <h5 class="text-danger text-center"><b>Are you sure you want to delete the course?</b></h5>
    <h5 class="text-success text-center"><b>Any course with result grade can not be deleted</b></h5>
                       <form class="form-horizontal" role="form" method="POST" action="{{ url('/removecourse') }}" data-parsley-validate>
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
                                            <tr class='success'>
                                            @endif
                                                <td>{{$c}}</td>
                                                <input type="hidden" name="id[]" value="{{$v['id']}}">
                                                <input type="hidden" name="level" value="{{$l}}">
                                                <input type="hidden" name="semester" value="{{$s}}">
                                                <input type="hidden" name="session" value="{{$ss}}">

                                                 <th>{{strtoupper($v->course_title)}}</th>
                                                <th>{{strtoupper($v->course_code)}}</th>
                                                  <th>{{$v->course_unit}}</th>
                                                <th>{{$v->course_status}}</th>
                                            </tr>
                                         @endforeach 
                                         <tr>  
                                           <td colspan="3">Total Unit</td>
                                                <td colspan="2">{{$pre->sum('course_unit')}} Unit</td>
                                            </tr> 
                                        </tbody>
                                    </table><!--//table-->
                           
                                  <div class="col-xs-6 col-sm-3 col-sm-offset-1">
                                   
                                <a href="{{url('deleteCourses')}}" class="btn ">
                                    <i class="fa fa-btn fa-arrow-circle-left"></i> Go Back
                                </a>
                            </div>

                           <div class="col-xs-6 col-sm-offset-5 col-sm-3">
                                   
                                <button type="submit" class="btn">
                                    <i class="fa fa-btn fa-user"></i> Delete
                                </button>
                            </div>
                                </form>
                              
                                @else
                         <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert">
    Your have not register for these semeter.
    
    </div>       
                                @endif
                                 @endif
                                 </div>
                </div>
                </div>
@endsection