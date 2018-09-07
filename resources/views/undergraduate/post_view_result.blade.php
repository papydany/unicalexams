@extends('layouts.displayresult')
@section('title','Home')
@section('content')
@inject('R','App\RRR')
    <div class="col-xs-12">
    <div class="col-xs-12">
    <p class="text-center">{{ strtoupper(Auth::user()->surname).
         
                    "&nbsp;". strtoupper(Auth::user()->firstname)."&nbsp;".strtoupper(Auth::user()->othername) . " - ".Auth::user()->matric_number.'&nbsp;('.$l.'00 level)'}}</p>
    </div>

 <div class="col-sm-6 table-responsive w22">
 @if(count($first_result) > 0)
 <table class="table table-bordered table-striped">
 <tr>
 <th colspan="8" class="text-danger text-center">First Semester
 </th>
 </tr>
 <tr>
<th>Course Code</th>
<th>Status</th>
<th>Unit</th>
<th>CA</th>
<th>EXM</th>
<th>T</th>
<th>Grade</th>
<th>Grade Point</th>
</tr>
    @foreach($first_result as $v)
<?php $cp =$R->get_cp($v->total,$v->cu); ?>
    <tr>
    <td>{{$v->course_code}}</td>
    <td>{{$v->course_status}}</td>
 <td>{{$v->cu}}</td>
  <th>{{$v->ca}}</th>
  <th>{{$v->exam}}</th>
   <th>{{$v->total}}</th>
  <td>{{$v->grade}}</td>
 <td>{{$cp}}</td>
  </tr>

   @endforeach


    @if(count($course_first) > 0)
   @foreach($course_first as $vc)
<tr>
    <td>{{$vc->course_code}}</td>
      <td>{{$vc->course_status}}</td>
 <td>{{$vc->course_unit}}</td>
  <td>NR</td> 
  <td>NR</td>
  <td>NR</td>
  <td>NR</td>
  <td>NR</td>
  </tr>
   @endforeach
   @endif
   </table>
   @endif
       </div>


<div class="col-sm-6 table-responsive w2">
 @if(count($second_result) > 0)
<table class="table table-bordered table-striped">
 <th colspan="8" class="text-danger text-center">Second Semester
 </th>
<tr>
<th>Course Code</th>
<th>Status</th>
<th>Unit</th>
<th>CA</th>
<th>EXM</th>
<th>T</th>
<th>Grade</th>
<th>Grade Point</th>
</tr>
@foreach($second_result as $v)
<?php $cp =$R->get_cp($v->total,$v->cu); ?>
    <tr>
    <td>{{$v->course_code}}</td>
    <td>{{$v->course_status}}</td>
 <td>{{$v->cu}}</td>
 <th>{{$v->ca}}</th>
  <th>{{$v->exam}}</th>
   <th>{{$v->total}}</th>
  <td>{{$v->grade}}</td>

  <td>{{$cp}}</td>
  </tr>

   @endforeach
   @if(count($course_second) > 0)
   @foreach($course_second as $vc)
<tr>
    <td>{{$vc->course_code}}</td>
      <td>{{$vc->course_status}}</td>
 <td>{{$vc->course_unit}}</td>
  <td>NR</td>
 <td>NR</td>
 <td>NR</td>
  <td>NR</td>
   <td>NR</td>
  </tr>
   @endforeach
   @endif
   </table>
   @endif
       </div>
       <div class="clear-fix"></div>
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
     @if(Auth::user()->entry_year <= 2016)

       <table class="table table-bordered">
       <tr>
       <th>Interprete Grade</th>
       <th>Interprete Remarks</th>
       <th>Interpretation</th>
       </tr>
       @if(Auth::user()->programme_id == 2)
       <!--  diploma students -->
       <tr>
       <td>A = 5.0</td> 
       <td><b>TAKE : </b>Mean previously dropped courses,to be taken in the current level</td>
       <td><b>CA : </b>Continuous Assessment Score</td>
       </tr>
        <tr>
       <td>B = 4.0</td> 
       <td>
<b>RESIT : </b>Means previously failed courses to be taken in the current level
      </td>
       <td><b>EXM : </b>Examination Scores</td>
       </tr>
        <tr>
       <td>C = 3.0</td> 
       <td><b>NR : </b>Mean no result, the lecturer have not uploaded yet.</td>
       <td><b>T : </b>Total Scores</td>
       
       </tr>
        <tr>
       <td>D = 2.0</td> 
       <td></td>
         <td><b>Status :</b>C = Compulsory Course</td>
       
       
       </tr>
        <tr>
       <td>E = 1.0</td> 
     
     
       </tr>
        <tr>
       <td>F = 0.0</td> 
       
       </tr>
       @else
        <tr>
       <td>A = 5.0</td> 
       <td><b>TAKE : </b>Mean previously dropped courses,to be taken in the current level</td>
       <td><b>CA : </b>Continuous Assessment Score</td>
       </tr>
        <tr>
       <td>B = 4.0</td> 
       <td><b>RPT : </b>Means previously failed courses to be taken in the current level</td>
       <td><b>EXM : </b>Examination Scores</td>
       </tr>
        <tr>
       <td>C = 3.0</td> 
       <td><b>NR : </b>Mean no result, the lecturer have not uploaded yet.</td>
       <td><b>T : </b>Total Scores</td>
       
       </tr>
        <tr>
       <td>D = 2.0</td> 
       <td><b>Probation : </b>Mean repeat the same level and rewirte all your failed and dropped courses</td>
       <td><b>Status :</b>E = Elective Course </td>
       </tr>
        <tr>
       <td>E = 1.0</td> 
       <td><b>Withdraw :</b>Means Stop studies</td>
       <td><b>Status :</b>C = Compulsory Course</td>
       </tr>
        <tr>
       <td>F = 0.0</td> 
       <td></td>
       </tr> 
       @endif   
       </table>

       @else
 <table class="table table-bordered">
       <tr>
       <th>Interprete Grade</th>
       <th>Interprete Remarks</th>
       <th>Interpretation</th>
       </tr>
       <tr>
        @if(Auth::user()->programme_id == 2)
       <td>A = 4.0</td> 
       <td><b>TAKE : </b>Mean previously dropped courses,to be taken in the current level</td>
       <td><b>CA : </b>Continuous Assessment Score</td>
       </tr>
        <tr>
       <td>B = 3.0</td> 
       <td>
        
<b>RESIT : </b>Means previously failed courses to be taken in the current level
      

      </td>
       <td><b>EXM : </b>Examination Scores</td>
       </tr>
        <tr>
       <td>C = 2.0</td> 
       <td><b>NR : </b>Mean no result, the lecturer have not uploaded yet.</td>
       <td><b>T : </b>Total Scores</td>
       
       </tr>
        <tr>
       <td>D = 1.0</td> 
       <td><b>Probation : </b>Mean repeat the same level and rewirte all your failed and dropped courses</td>
       <td><b>Status :</b>E = Elective Course </td>
       </tr>
        <tr>
       <td>F = 0.0</td> 
       <td><b>Withdraw :</b>Means Stop studies</td>
       <td><b>Status :</b>C = Compulsory Course</td>
       </tr>
       @else
          

<tr>
       <td>A = 4.0</td> 
       <td><b>TAKE : </b>Mean previously dropped courses,to be taken in the current level</td>
       <td><b>CA : </b>Continuous Assessment Score</td>
       </tr>
        <tr>
       <td>B = 3.0</td> 
       <td>
  
        <b>RPT : </b>Means previously failed courses to be taken in the current level
        

      </td>
       <td><b>EXM : </b>Examination Scores</td>
       </tr>
        <tr>
       <td>C = 2.0</td> 
       <td><b>NR : </b>Mean no result, the lecturer have not uploaded yet.</td>
       <td><b>T : </b>Total Scores</td>
       
       </tr>
        <tr>
       <td>D = 1.0</td> 
       <td><b>Probation : </b>Mean repeat the same level and rewirte all your failed and dropped courses</td>
       <td><b>Status :</b>E = Elective Course </td>
       </tr>
        <tr>
       <td>F = 0.0</td> 
       <td><b>Withdraw :</b>Means Stop studies</td>
       <td><b>Status :</b>C = Compulsory Course</td>
       </tr>
       @endif

       </table>

       @endif
       </div>
       </div>
    </div>
    </div>


@endsection