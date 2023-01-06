@extends('layouts.main')
@section('title','Home')
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
         <li class="current">Undergraduate</li>
       </ul>
     </div><!--//breadcrumbs-->
   </header> 
    
   <div class="page-content">                 
     <div class="row page-row">
        <div class="team-wrapper col-xs-12">        
         <div class="row page-row" >
         
           <div class="col-sm-6">
            <p><b>Session :</b>{{$s.'/'.$next }}</p>
           </div>
           <div class="col-sm-6">
                 <p><b>Level :</b>{{$l}}00 </p>
                 
          </div>
            
          <div class="clearfix"></div>
            
            @if(isset($rc))
            @if(!empty($rc) > 0)
              <p class="text-danger">Select the check box to choose the couress you want to register</p>     
              <form class="form-horizontal" role="form" method="GET" action="{{ url('returning_medicine_preview_course') }}" data-parsley-validate>
              {{ csrf_field() }}                     
            <table class="table table-boxed">
              <thead>
               <tr>
                 <th>#e</th>
                 <th>Select <input type="checkbox" id="all_ids" ></th></th>
                 <th>Title</th>
               
              </tr>
            </thead>
          <tbody>
        {{!!$c = 0}}

<input type="hidden" name="period" value="{{$p}}">
<input type="hidden" name="level" value="{{$l}}">
<input type="hidden" name="semester" value="1">
<input type="hidden" name="session" value="{{$s}}">

           @foreach($rc as $v)
            {{!++$c}}
@if(($c % 2)== 0)
  <tr>
  @else
  <tr class='danger'>
  @endif
  <td>{{$c}}</td>
 <td><input type="checkbox" class="ids" name="id[]" value="{{$v->id}}"></td> 
 <td>{{strtoupper($v->reg_course_title)}}</td>
 

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
        

          @if(isset($fc))
            @if(!empty($fc) > 0)
              <p class="text-danger">Failed course Selected Already</p>     
              <form class="form-horizontal" role="form" method="GET" action="{{ url('returning_medicine_preview_course') }}" data-parsley-validate>
              {{ csrf_field() }}                     
            <table class="table table-boxed">
              <thead>
               <tr>
                 <th>#v</th>
                 <th>Select <input type="checkbox" id="all_ids" ></th></th>
                 <th>Title</th>
               
              </tr>
            </thead>
          <tbody>
        {{!!$c = 0}}

<input type="hidden" name="period" value="{{$p}}">
<input type="hidden" name="level" value="{{$l}}">
<input type="hidden" name="semester" value="1">
<input type="hidden" name="session" value="{{$s}}">

           @foreach($fc as $v)
            {{!++$c}}
@if(($c % 2)== 0)
  <tr>
  @else
  <tr class='danger'>
  @endif
  <td>{{$c}}</td>
 <td><input type="checkbox"  name="id[]" value="{{$v->id}}" checked disabled>
   <input type="hidden" name="idf[]" value="{{$v->id}}"></td> 
 <td>{{strtoupper($v->reg_course_title)}}</td>
 
 
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