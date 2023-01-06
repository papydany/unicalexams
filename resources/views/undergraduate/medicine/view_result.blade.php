@extends('layouts.displayresult')
@section('title','Home')
@section('content')
@inject('R','App\RRR')
    <div class="col-xs-12">
    <div class="col-xs-12">
    <p class="text-center">{{ strtoupper(Auth::user()->surname).
         
                    "&nbsp;". strtoupper(Auth::user()->firstname)."&nbsp;".strtoupper(Auth::user()->othername) . " - ".Auth::user()->matric_number.'&nbsp;('.$l.'00 level)'}}</p>
    </div>

 <div class="col-sm-12 table-responsive w22m">
 @if(count($firstresult) > 0)
 <table class="table table-bordered table-striped">
 <tr>
 </tr>
 <tr>
<th>Course Code</th>
<th>Title</th>
<th>Grade</th>
</tr>
    @foreach($firstresult as $v)
<?php $cp =$R->get_cp($v->total,$v->cu); ?>
    <tr>
    <td>{{$v->course_code}}</td>
    <td>{{$v->course_title}}</td>
 <td>{{$v->grade}}</td>
  </tr>

   @endforeach


    @if(count($coursefirst) > 0)
   @foreach($coursefirst as $vc)
<tr>
    <td>{{$vc->course_code}}</td>
      <td>{{$vc->course_title}}</td>
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
       <th>Interprete Grade</th>
       <th>Remarks</th>
      
       </tr>
     
       <tr>
       <td>D = DISTINTION</td> 
       <td></td>
      
       </tr>
        <tr>
       <td>P = PASS</td> 
       <td>

      </td>
      
       </tr>
        <tr>
       <td>F = FAIL</td> 
       <td></td>
      
       
       </tr>
        <tr>
       <td>NR = NO Result</td> 
       <td></td>
         
       
       </tr>
      
        
       </table>
     
       </div>
       </div>
    </div>
    </div>


@endsection