@extends('layouts.main')
@section('title','Home')
@section('content')
<div class="content container">
  <div class="page-wrapper">
   <header class="page-heading clearfix">
     <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
        "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong><strong class="text-success">&nbsp;({{Auth::user()->matric_number}})</strong>
        
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
          
         
           <form class="form-horizontal" role="form" method="GET" action="{{ url('returningStudentMedicine')}}" data-parsley-validate>
            {{ csrf_field() }}
                <div class="form-group">
                <input type="hidden" name="session" value="{{$s}}"/>
                    <div class="col-sm-3 m10px">
                  
                        <select name="session"   class="form-control" readonly>
                            <option value="{{$s}}">{{$s." / ".$next}} session</option>
                        </select>
                     
                    </div>
                    <div class="col-sm-3 m10px">
                        <select name="level" class="form-control" required >
                        <option value="">Select</option>
                        <option value="2">200 Level</option>
                            <option value="3">Part I</option>
                            <option value="4">Part II</option>
                            <option value="5">Part III</option>
                            <option value="6">Part IV</option>
                        </select>
                    </div>

                    <div class="col-sm-3 m10px">
                        <select name="period" class="form-control" required>
                            <option value="">-- Select  --</option>
                           
                                    <option value="NORMAL">NORMAL</option>
                                    <option value="VACATION">RESIT</option>
                           
                        </select>
                    </div>
                   <div class="col-sm-3 m10px">
                   <input type="submit" class="btn" value="Continue">
                   </div>

                </div>

            </form>
         </div>
       </div>
     </div>
   </div>
  </div>
</div>

@endsection