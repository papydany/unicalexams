@extends('layouts.main')
@section('title','Home')
@section('content')

<div class="content container">
  <div class="page-wrapper">
   <header class="page-heading clearfix">
    <h4 class="text-center text-primary"><b><u>RETURNING STUDENTS  COURSE REGISTRATION</u></b></h4>
                
                <h4 class="heading-title pull-left"><strong class=''>{{ strtoupper(Auth::user()->surname.
         
                    " ". Auth::user()->firstname." ".Auth::user()->othername )}}</strong>
                    <strong class="text-primary">{{Auth::user()->matric_number}}</strong></h4>
                <div class="breadcrumbs pull-right">
                    <ul class="breadcrumbs-list">
                        <li class="breadcrumbs-label">You are here:</li>
                        <li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                        <li class="current">Register Courses </li>
                    </ul>
                </div><!--//breadcrumbs-->

   </header> 
      
           
        
   <div class="page-content">                 
     <div class="row page-row">
                       
       <div class="team-wrapper col-xs-12">        
         <div class="row page-row" >
          @if(isset($r))
         
 
          <h3 class="text-danger">Mopped Exams Registration </h3>
            <form class="form-horizontal" role="form" method="GET" action="{{ url('moppedUp_semester_courses')}}" data-parsley-validate>
            {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-3">
                  
                        <select name="session"   class="form-control" readonly>
                            <option value="{{$s}}">{{$s." / ".$next}} session</option>
                        </select>
                     
                    </div>
                    <div class="col-sm-3">
                        <select name="level" class="form-control" required readonly>
                            <option value="{{$l}}">{{$l}}00 Level</option>
                        </select>
                    </div>

                  <div class="col-sm-3">
                   <input type="submit" class="btn" value="Continue">
                   </div>

                </div>

            </form>

        
          @endif
           
         </div>
       </div>
     </div>
   </div>
  </div>
</div>

@endsection