@extends('layouts.olddisplayresult')
@section('title','Home')
@section('content')

    <div class="col-xs-12">
    <div class="col-xs-12">
    <p class="text-center">{{$name. " - ".$matric_no.'&nbsp;('.$level.'00 level)'}}</p>
    </div>

 <div class="col-sm-6 table-responsive w2">
 @if(count($result_first) > 0)
 <table class="table table-bordered table-striped">
 <tr>
 <th colspan="5" class="text-danger text-center">First Semester
 </th>
 </tr>
 <tr>
<th>Course Code</th>
<th>Status</th>
<th>Unit</th>

<th>Grade</th>
<th>Grade Point</th>
</tr>
    @foreach($result_first as $v)

    <tr>
    <td>{{$v->stdcourse_custom2}}</td>
      <td>{{$v->stdcourse_custom3}}</td>
 <td>{{$v->c_unit}}</td>
  <td>{{$v->std_grade}}</td>

 <td>{{$v->cp}}</td>
  </tr>

   @endforeach


    @if(count($course_first) > 0)
   @foreach($course_first as $vc)
<tr>
    <td>{{$vc->stdcourse_custom2}}</td>
      <td>{{$vc->stdcourse_custom3}}</td>
 <td>{{$vc->c_unit}}</td>
  <td>NR</td>

  <td>NR</td>
  </tr>
   @endforeach
   @endif
   </table>
   @endif
       </div>


<div class="col-sm-6 table-responsive w2">
 @if(count($result_second) > 0)
<table class="table table-bordered table-striped">
 <th colspan="5" class="text-danger text-center">Second Semester
 </th>
<tr>
<th>Course Code</th>
<th>Status</th>
<th>Unit</th>
<th>Grade</th>

<th>Grade Point</th>
</tr>
@foreach($result_second as $v)

    <tr>
    <td>{{$v->stdcourse_custom2}}</td>
      <td>{{$v->stdcourse_custom3}}</td>
 <td>{{$v->c_unit}}</td>
  <td>{{$v->std_grade}}</td>

  <td>{{$v->cp}}</td>
  </tr>

   @endforeach
   @if(count($course_second) > 0)
   @foreach($course_second as $vc)
<tr>
    <td>{{$vc->stdcourse_custom2}}</td>
      <td>{{$vc->stdcourse_custom3}}</td>
 <td>{{$vc->c_unit}}</td>
  <td>NR</td>

  <td>NR</td>
  </tr>
   @endforeach
   @endif
   </table>
   @endif
       </div>
       <div class="col-xs-12 table-responsive w4">
     
       <table class="table table-bordered">
       <tr>
       <th>GPA</th>
        <th>CGPA</th>
        <th>Remarks</th>
       </tr>
       <tr>
       <td>{{isset($gpa) ? $gpa :''}}</td>
        <td>{{isset($cgpa) ? $cgpa : ''}}</td>
         <td>{!!isset($r) ? $r : ''!!}</td>
       </tr>
       	
       </table>


       </div>
<div class="col-xs-12 table-responsive w4">
     
       <table class="table table-bordered">
       <tr>
       <th>Interprete Grade</th>
       <th>Interprete Remarks</th>
       </tr>
       <tr>
       <td>A = 5.0</td> 
       <td><b>TAKE :</b>Previously dropped courses,to be taken in the next level</td>
       </tr>
        <tr>
       <td>B = 4.0</td> 
       <td><b>RPT :</b> Previously failed courses to be taken in the next level</td>
       </tr>
        <tr>
       <td>C = 3.0</td> 
       <td><b>NR :</b>No result; the lecturer has not uploaded his result.</td>
       </tr>
        <tr>
       <td>D = 2.0</td> 
       <td><b>Probation : </b>Repeat the same level and rewirte all your failed and dropped courses</td>
       </tr>
        <tr>
       <td>E = 1.0</td> 
       <td><b>Withdraw :</b>Stop studies;You are no longer a student of the University</td>
       </tr>
        <tr>
       <td>F = 0.0</td> 
       <td></td>
       </tr>  	
       </table>
       </div>
       </div>
    </div>
    </div>


@endsection