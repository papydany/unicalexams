@extends('layouts.main')
@section('title','Home')
@section('content')
<div class="content container">
  <div class="page-wrapper">
   <header class="page-heading clearfix">
     <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
        "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong><strong class="text-success">({{Auth::user()->matric_number}})</strong>
        
     </h1>

     <div class="breadcrumbs pull-right">
       <ul class="breadcrumbs-list">
         <li class="breadcrumbs-label">You are here:</li>
         <li><a href="url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
         <li class="current">Undergraduate</li>
       </ul>
     </div><!--//breadcrumbs-->

   </header> 
      
           <h3><strong class="text-success">PIN VALID FOR &nbsp;
            <?php $s = session()->get('session_year');
            $next =session()->get('session_year') +1;?>
            {{$s.'/'.$next }} &nbsp; SESSION
          </strong></h3>
           <p class="text-danger" style="font-size: 1.3em;text-decoration: underline"> RESIT COURSE REGISTRATION</p>
        
   <div class="page-content">                 
     <div class="row page-row">
                       
       <div class="team-wrapper col-xs-12">        
         <div class="row page-row" >
    
           <form class="form-horizontal" role="form" method="POST" action="{{ url('register_resit_course')}}" data-parsley-validate>
            {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-3">
                  
                        <select name="session"   class="form-control" readonly>
                            <option value="{{$s}}">{{$s." / ".$next}} session</option>
                        </select>
                     
                    </div>
                    <div class="col-sm-3">
                        <select name="level" class="form-control" required readonly>
                            <option value="{{$l}}">{{$l}}00</option>
                        </select>
                    </div>

                  
                   <div class="col-sm-3">
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