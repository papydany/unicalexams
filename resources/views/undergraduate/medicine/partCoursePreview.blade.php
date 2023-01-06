@extends('layouts.main')
@section('title','Preview Course ')
@section('content')
<div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
         
                    "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername ."&nbsp;(".Auth::user()->matric_number.")"}}</strong>
                    <?php $next =$s +1;?>

                </h1>
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
                <div class="table-responsive col-sm-12">
                
          
           <div class="col-sm-6">
            <p><b>Session :</b>{{$s.'/'.$next }}</p>
                    </div>
                    <div class="col-sm-6">
                 <p><b>Level :</b>{{$l}}00 </p>
                  
          </div>
         
          <div class="clearfix"></div>
            

@if($tu == 0)
    <div class=" col-sm-10 col-sm-offset-1 alert alert-danger" role="alert">
     Minimum course unit allowed is 2 units.
     Contact your <strong> examination Officer </strong> if you need more clerification.
     <br/> <br/>
     <a href="{{url()->previous()}}" class="btn"><i class="fa fa-btn fa-arrow-circle-left"></i> Go Back </a>
  </div> 
@else
    <form class="form-horizontal" role="form" method="POST" action="{{ url('returning_post_medicine_register_course') }}" data-parsley-validate>
    {{ csrf_field() }}
    <table class="table table-boxed">
        <thead>
          <tr>
             <th>#</th>
             <th>Title</th>
             <th>Code</th>
           
         </tr>
     </thead>
    <tbody>
 {{!!$c = 0}}
<input type="hidden" name="level" value="{{$l}}">
<input type="hidden" name="period" value="{{$p}}">
<input type="hidden" name="semester" value="{{$sn->semester_id}}">
<input type="hidden" name="session" value="{{$s}}">
@if(!empty($pref))
    @foreach($pref as $vf)
        {{!++$c}}
        @if(($c % 2)== 0)
            <tr>
        @else
          <tr class='danger'>
        @endif
        <td>{{$c}}</td>
        <input type="hidden" name="idf[]" value="{{$vf['id']}}">
        <td>{{strtoupper($vf->reg_course_title)}}</td>
        <td>{{strtoupper($vf->reg_course_code)}}</td>
       
        </tr>
    @endforeach 
@endif 
@if(!empty($pred))
    @foreach($pred as $vd)
        {{!++$c}}
        @if(($c % 2)== 0)
            <tr>
        @else
          <tr class='danger'>
        @endif
        <td>{{$c}}</td>
        <input type="hidden" name="idd[]" value="{{$vd['id']}}">
        <td>{{strtoupper($vd->reg_course_title)}}</td>
        <td>{{strtoupper($vd->reg_course_code)}}</td>
       
        </tr>
    @endforeach 
@endif                                           
@if(!empty($pre))
    @foreach($pre as $v)
        {{!++$c}}
        @if(($c % 2)== 0)
            <tr>
        @else
          <tr class='danger'>
        @endif
        <td>{{$c}}</td>
        <input type="hidden" name="id[]" value="{{$v['id']}}">
        <td>{{strtoupper($v->reg_course_title)}}</td>
        <td>{{strtoupper($v->reg_course_code)}}</td>
       
        </tr>
    @endforeach 
@endif

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