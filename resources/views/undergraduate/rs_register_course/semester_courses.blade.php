@extends('layouts.main')
@section('title','Home')
@section('content')
<div class="content container">
  <div class="page-wrapper">
   <header class="page-heading clearfix">
     <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
        "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername ."&nbsp;(".Auth::user()->matric_number.")"}}</strong>
        <?php $next =session()->get('session_year') +1;?>
     </h1>
     <div class="breadcrumbs pull-right">
       <ul class="breadcrumbs-list">
         <li class="breadcrumbs-label">You are here:</li>
         <li><a href="url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
         <li class="current">Undergraduate</li>
       </ul>
     </div><!--//breadcrumbs-->
   </header> 
    
   <div class="page-content">                 
     <div class="row page-row">
        <div class="team-wrapper col-xs-12">        
         <div class="row page-row" >
          <div class="col-sm-6">
            <h4><strong class="text-success">PIN VALID FOR &nbsp; {{session()->get('session_year').'/'.$next }} &nbsp; SESSION</strong></h4>
             <p class=" text-center" style="background-color: #0ff; padding: 10px"><b> Direct Entry students,  100 level, is your first year of three or four years programme</b></p>
          </div>
           <div class="col-sm-3">
            <p><b>Session :</b>{{session()->get('session_year').'/'.$next }}</p>
                 <p><b>Level :</b>{{$l}}00 </p>
                  <p><b>Semester :</b>{{$sn->semester_name}}</p>
          </div>
            <div class="col-sm-3">
              <p class="text-danger"><b>Course Status</b></p>
            <p><b>C : </b>Compulsary</p>
                 <p><b>E : </b>Elective</p>
                  <p><b>R : </b>Failed course In Last Session</p>
                    <p><b>D : </b>Drop course In Last Session</p>
          </div>
          <div class="clearfix"></div>
            
            @if(isset($rc))
            @if(!empty($rc) > 0)
              <p class="text-danger">Select the check box to choose the couress you want to register</p>     
              <form class="form-horizontal" role="form" method="GET" action="{{ url('returning_preview_course') }}" data-parsley-validate>
              {{ csrf_field() }}                     
            <table class="table table-boxed">
              <thead>
               <tr>
                 <th>#</th>
                 <th>Select</th>
                 <th>Title</th>
                 <th>Code</th>
                 <th>Unit</th>
                 <th>Status</th>
              </tr>
            </thead>
          <tbody>
        {{!!$c = 0}}


<input type="hidden" name="level" value="{{$l}}">
<input type="hidden" name="semester" value="{{$sn->semester_id}}">
  @if(!empty($frc) > 0)
    @foreach($frc as $vf)
     {{!++$c}}
     @if(($c % 2)== 0)
     <tr>
     @else
     <tr class='danger'>
     @endif
     <td>{{$c}}</td>
     <td>
      <input type="checkbox" name="id[]" value="{{$vf->id}}" checked disabled>
      <input type="hidden" name="idf[]" value="{{$vf->id}}">
     </td> 
     <td>{{strtoupper($vf->reg_course_title)}}</td>
     <td>{{strtoupper($vf->reg_course_code)}}</td>
     <td>{{$vf->reg_course_unit}}</td>
     <td>R</td>
     </tr>
    @endforeach 
  @endif

  @if(!empty($drc) > 0)
   @foreach($drc as $vd)
    {{!++$c}}
    @if(($c % 2)== 0)
    <tr>
    @else
    <tr class='danger'>
    @endif
    <td>{{$c}}</td>                                            
    <td><input type="checkbox" name="id[]" value="{{$vd->id}}" checked disabled>
   <input type="hidden" name="idd[]" value="{{$vd->id}}">
    </td> 
    <td>{{strtoupper($vd->reg_course_title)}}</td>
    <td>{{strtoupper($vd->reg_course_code)}}</td>
    <td>{{$vd->reg_course_unit}}</td>
    <td>D</td>
    </tr>
  @endforeach
@endif
           @foreach($rc as $v)
            {{!++$c}}
@if(($c % 2)== 0)
  <tr>
  @else
  <tr class='danger'>
  @endif
  <td>{{$c}}</td>
 <td><input type="checkbox" name="id[]" value="{{$v->id}}"></td> 
 <td>{{strtoupper($v->reg_course_title)}}</td>
 <td>{{strtoupper($v->reg_course_code)}}</td>
 <td>{{$v->reg_course_unit}}</td>
 <td>{{$v->reg_course_status}}</td>
  </tr>
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