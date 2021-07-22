@extends('layouts.main')
@section('title','Summer Courses')
@section('content')
<div class="content container">
  <div class="page-wrapper">
   <header class="page-heading clearfix">
    <h4 class="text-center text-primary"><b><u>SUMMER REGISTRATION OF COURSES</u></b></h4>
                
    <h4 class="heading-title pull-left"><strong class=''>{{ strtoupper(Auth::user()->surname.

        " ". Auth::user()->firstname." ".Auth::user()->othername )}}</strong>
        <strong class="text-primary">{{Auth::user()->matric_number}}</strong></h4>
    <div class="breadcrumbs pull-right">
        <ul class="breadcrumbs-list">
            <li class="breadcrumbs-label">You are here:</li>
            <li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
            <li class="current">Summer Registration </li>
        </ul>
    </div><!--//breadcrumbs-->
   </header> 
    
   <div class="page-content">                 
     <div class="row page-row">
        <div class="team-wrapper col-xs-12">        
         <div class="row page-row" >
          <div class="col-sm-6">
              <p class=" text-center" style="background-color: #0ff; padding: 10px"><b> Direct Entry students,  100 level, is your first year of three or four years programme</b></p>
          </div>
           <div class="col-sm-3">
            <h5><b>Session :</b>{{$ss.'/'.$next }}</h5>
                 <h5><b>Level :</b>{{$l}}00 </h5>
                  <h5><b>Semester :</b>First & Second</h5>
          </div>
            <div class="col-sm-3">
              <p class="text-danger"><b>Course Status</b></p>
            <p><b>C : </b>Compulsary</br>
                 <b>E : </b>Elective</br>
                  <b>R : </b>Failed course In Last Session</br>
                    <b>D : </b>Drop course In Last Session</p>
          </div>
          <div class="clearfix"></div>
         
          @if(isset($r))
        <h1 class="text-center text-danger">  {{$r}} </h1>

          @endif
            
            @if(isset($rc))
            @if(!empty($rc) > 0)
              <h4 class="text-danger text-center">Select the check box to choose the couress you want to register</h4>     
              <form class="form-horizontal" role="form" method="GET" action="{{ url('previewSummerCourse') }}" data-parsley-validate>
              {{ csrf_field() }}                     
            <table class="table table-boxed">
              <thead>
               <tr>
                 <th>#</th>
                 <th>Select <input type="checkbox" id="all_ids" ></th></th>
                 <th>Title</th>
                 <th>Code</th>
                 <th>Unit</th>
                 <th>Status</th>
              </tr>
            </thead>
          <tbody>
        {{!!$c = 0}}


<input type="hidden" name="level" value="{{$l}}">
<input type="hidden" name="session" value="{{$ss}}">
<?php $collection = $rc->groupBy('semester_id');?>
           @foreach($collection as $k => $item)
           <tr>
           
           <th colspan="6" class='text-center'>@if($k == 1)First
           <input type="hidden" name="Firstsemeter" value="{{$k}}">
           @elseif($k== 2)
           <input type="hidden" name="Secondsemeter" value="{{$k}}">
           Second 
           @endif Semester</th></tr>
           @foreach($item as  $v)
            {{!++$c}}
@if(($c % 2)== 0)
  <tr>
  @else
  <tr class='success'>
  @endif
  <td>{{$c}}</td>
 <td><input type="checkbox" class="ids" name="id[]" value="{{$v->id}}"></td> 
 <td>{{strtoupper($v->reg_course_title)}}</td>
 <td>{{strtoupper($v->reg_course_code)}}</td>
 <td>{{$v->reg_course_unit}}</td>
 <td>@if($v->reg_course_status == 'C')
   C 
   @else R
   @endif</td>
  </tr>
@endforeach 
@endforeach 
</tbody>
</table><!--//table-->
          <div class="col-sm-offset-8 col-sm-4">
             <button type="submit" class="btn btn-lg"><i class="fa fa-btn fa-user"></i> Preview</button>
          </div>
    </form>
           @else
<div class=" col-sm-10 col-sm-offset-1 alert alert-danger" role="alert" >
You cant continue with courses registration, because there is no registered courses for these session. Please Contact the system admin or your examination officer.
    </div>
           @endif



          @endif
        


                    
         </div>
       </div>
     </div>
   </div>
  </div>
</div>

@endsection