@extends('layouts.main')
@section('title','Home')
@section('content')
<div class="content container">
  <div class="page-wrapper">
   <header class="page-heading clearfix">
    <h4 class="text-center text-primary"><b><u>PREVIEW RESIT COURSE REGISTRATION</u></b></h4>
                
    <h4 class="heading-title pull-left"><strong class=''>{{ strtoupper(Auth::user()->surname.

        " ". Auth::user()->firstname." ".Auth::user()->othername )}}</strong>
        <strong class="text-primary">{{Auth::user()->matric_number}}</strong></h4>
    <div class="breadcrumbs pull-right">
        <ul class="breadcrumbs-list">
            <li class="breadcrumbs-label">You are here:</li>
            <li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
            <li class="current">Preview Resit courses </li>
        </ul>
    </div><!--//breadcrumbs-->
   </header> 
    
   <div class="page-content">                 
     <div class="row page-row">
        <div class="team-wrapper col-xs-12">        
         <div class="row page-row" >
          
           <div class="col-sm-3">
            <h5><b>Session :</b>{{$s.'/'.$next }}</h5>
                 <h5><b>Level :</b>{{$l}}00 </h5>
                  <h5><b>Semester :</b>FIRST & SECOND</h5>
          </div>
            <div class="col-sm-3">
              <p class="text-danger"><b>Course Status</b></p>
              <p><b>R : </b>Failed course In Last Session</p>
                  
          </div>
          <div class="clearfix"></div>
            
            @if(isset($rg))
            @if(!empty($rg) > 0)
                  
              <form class="form-horizontal" role="form" method="POST" action="{{ url('register_resit_course1') }}" data-parsley-validate>
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

<input type="hidden" name="session" value="{{$s}}">
<input type="hidden" name="level" value="{{$l}}">
  
    @foreach($rg as $vf)
     {{!++$c}}
     @if(($c % 2)== 0)
     <tr>
     @else
     <tr class='success'>
     @endif
     <td>{{$c}}</td>
     <td>
      <input type="checkbox" name="id[]" value="{{$vf->id}}" checked disabled>
 <input type="hidden" name="idd[]" value="{{$vf->id}}">
     </td> 
     <td>{{strtoupper($vf->reg_course_title)}}</td>
     <td>{{strtoupper($vf->reg_course_code)}}</td>
     <td>{{$vf->reg_course_unit}}</td>
     <td>R</td>
     </tr>
    @endforeach 




</tbody>
</table><!--//table-->
          <div class="col-sm-offset-8 col-sm-4">
             <button type="submit" class="btn btn-lg"><i class="fa fa-btn fa-user"></i>Register</button>
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