@extends('layouts.main')
@section('title','Preview Course')
@section('content')
<div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h4 class="text-center text-primary"><b><u>PREVIEW SUMMER REGISTRATION OF COURSES</u></b></h4>
                
                    <h4 class="heading-title pull-left"><strong class=''>{{ strtoupper(Auth::user()->surname.
             
                        " ". Auth::user()->firstname." ".Auth::user()->othername )}}</strong>
                        <strong class="text-primary">{{Auth::user()->matric_number}}</strong></h4>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">Preview Summer Registration </li>
                        </ul>
                    </div><!--//breadcrumbs-->
                </header> 
                </div>
                <div class="row" style="margin-bottom: 20px;">
                <div class="table-responsive col-sm-12">
                
                   <div class="col-sm-6">
              <p class=" text-center" style="background-color: #0ff; padding: 10px"><b> Direct Entry students,  100 level, is your first year of three or four years programme</b></p>
          </div>
           <div class="col-sm-3">
            <h5><b>Session :</b>{{$s.'/'.$next }}</h5>
                 <h5><b>Level :</b>{{$l}}00 </h5>
                  <h5><b>Semester :</b>First & Second</h5>
          </div>
            <div class="col-sm-3">
              <p class="text-danger"><b>Course Status</b></p>
            <p><b>C : </b>Compulsary<br/>
                 <b>E : </b>Elective</br/>
                  <b>R : </b>Failed course In Last Session<br/>
                    <b>D : </b>Drop course In Last Session</p>
          </div>
          <div class="clearfix"></div>
            
@if($tu > $tcu)
 <div class=" col-sm-10 col-sm-offset-1 alert alert-danger" role="alert">
     Total number of course unit  select is above {{$tcu}} units . maximum course unit for these semester.
     Contact your <strong> examination Officer </strong> if you need more clerification.
     <br/> <br/>
     <a href="{{url()->previous()}}" class="btn"><i class="fa fa-btn fa-arrow-circle-left"></i> Go Back </a>
 </div> 

   
@else
    <form class="form-horizontal" role="form" method="POST" action="{{ url('postSummerCourse') }}" data-parsley-validate>
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
<input type="hidden" name="level" value="{{$l}}">
<input type="hidden" name="session" value="{{$s}}">
                                          
@if(!empty($pre))
<?php $collection =$pre->groupBy('semester_id'); ?>
@foreach($collection as $k => $items)
<tr>
           
           <th colspan="6" class='text-center'>@if($k == 1)First
          
           @elseif($k== 2)
           
           Second 
           @endif Semester</th></tr>
    @foreach($items as $v)
        {{!++$c}}
        @if(($c % 2)== 0)
            <tr>
        @else
          <tr class='success'>
        @endif
        <td>{{$c}}</td>
        <input type="hidden" name="id[]" value="{{$v['id']}}">
        <td>{{strtoupper($v->reg_course_title)}}</td>
        <td>{{strtoupper($v->reg_course_code)}}</td>
        <td>{{$v->reg_course_unit}}</td>
        <td>{{$v->reg_course_status}}</td>
        </tr>
    @endforeach 
    @endforeach 
@endif
<tr>  
  <td colspan="3">Total Unit</td>
 <td colspan="2">{{$tu}} Unit</td>
</tr> 
</tbody>
</table><!--//table-->
<div class="col-xs-6 col-sm-3 col-sm-offset-1">
 <a href="{{url()->previous()}}" class="btn "><i class="fa fa-btn fa-arrow-circle-left"></i> Go Back</a>
</div>
<div class="col-xs-6 col-sm-offset-5 col-sm-3">
    <button type="submit" class="btn"> <i class="fa fa-btn fa-user"></i> Register</button>
</div>
</form>
                              
     
                                @endif
                             
                                 </div>
                </div>
                </div>
@endsection