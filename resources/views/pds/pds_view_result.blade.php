@extends('layouts.pdsdisplay')
@section('title','Result ')
@section('content')
   <div class="content container" style="min-height: 425px;">
        <div class="page-wrapper">
            <header class="page-heading clearfix">
                <h1 class="text-danger text-center"><strong>{{ Auth::user()->surname.
         
                    "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong></h1>
                
            </header>
        </div>
        <div class="row">
        <table class="table table-bordered">
            <tr>
            <td >S/N</td>
            <td>Course</td>
            <td colspan="2">First Semester
            <td  colspan="2">Second Semester</td>
            <td>Avg Score</td>
            <td>Grade</td>
            <td>Point</td>
           </tr>
           <tr>
           <td colspan="2"></td>
            <td>Score</td>
            <td>Grade 1</td>
            <td>Score</td>
            <td>Grade 2</td>
            <td colspan="3"></td>
           </tr>
         
     @inject('r','App\RRR')


  <?php $c = 0;?> 
  @foreach($cc as $v)
<?php $r1= $r->pds_result(Auth::user()->id,$v->id,Auth::user()->matric_number,$ss,1); 
$r2= $r->pds_result(Auth::user()->id,$v->id,Auth::user()->matric_number,$ss,2); 

$avg = $r->get_course_avg(Auth::user()->id,$v->id,$ss);

$gp =$r->get_course_grade_point($avg);

 ?>
  <tr>
  <td>{{++$c}}</td>
      <td>{{strtoupper($v->course_title)}}</td>
      <td>
      {{isset($r1->total) ? $r1->total : " "}}</td>
      <td>
    {{isset($r1->grade) ? $r1->grade : " "}}
      </td>
      <td>
      {{isset($r2->total) ? $r2->total : " "}}</td>
      <td>
      {{isset($r2->grade) ? $r2->grade : " "}}
      </td>
      <td>{{isset($avg) ? $avg : " "}}</td>
      <td>{{$gp['grade']}}</td>
      <td>{{$gp['point']}}</td>
   </tr>

  @endforeach   
        </table>

        </div>
      
                   

                    
       
    </div>
@endsection