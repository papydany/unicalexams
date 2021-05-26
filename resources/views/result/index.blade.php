@extends('layouts.oldmain')
@section('title','Home')
@section('content')
    <div class="content container">
    <div class="row">
    <div class="col-xs-12">
    <div class="col-sm-5">
    <p  class="text-success"> {{$name}}</p>
    <p  class="text-danger"><strong>Matric Number: </strong>{{$matric_no}}</p>
 
    <p  class="text-info"><strong>Session :</Strong>{{$year.' / '.$yearplus}}</p>

    <p class="text-danger"><b>NB:: you can only check your result for these sessions and below</b></p>
    </div>

<div class="col-sm-6">

<h3>Sessions </h3>
@foreach($getsession as $v)
{{!$v_next = $v->std_mark_custom2 + 1}}
<p><a  class="btn btn-success btn-lg btn-block" target="_blank" href="{{url('check_result',[$v->std_mark_custom2,$v->period])}}"> 
 @if($v->period == 'VACATION')
 {{$v->std_mark_custom2.' / '.$v_next.'&nbsp;&nbsp;'. $v->period}}
 @else
 {{$v->std_mark_custom2.' / '.$v_next}}
 @endif
 </a></p>

@endforeach
    </div>
    </div>

    </div>

    </div>

@endsection