@extends('layouts.main')
@section('title','Home')
@section('content')
<div class="content container">
  <div class="page-wrapper">
   <header class="page-heading clearfix">
     <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
        "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong>
        <?php $next =session()->get('session_year') +1;?>{{session()->get('session_year').'/'.$next }}
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
        
<aside class="page-sidebar col-md-3 col-sm-4 affix-top">                    
  <section class="widget">
   <ul class="nav">
      <li class="active"><a href="{{url('register_first_semester_courses')}}">Register First Semester Courses</a></li>
      <li class="active"><a href="{{url('register_second_semester_courses')}}">Register Second Semester Courses</a></li>
      <li class="active"><a href="buttons.html">Print Register Courses</a></li>
      <li class="active"><a href="components.html">Add Courses</a></li>
      <li class="active"><a href="icons.html">Delete Courses</a></li>                            
   </ul>                    
 </section>
</aside>
{{session()->get('paidschoolfess')}}
                    
         </div>
       </div>
     </div>
   </div>
  </div>
</div>

@endsection