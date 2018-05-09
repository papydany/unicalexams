@extends('layouts.main')
@section('title','Home')
@section('content')
<div class="content container">
  <div class="page-wrapper">
   <header class="page-heading clearfix">
     <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
        "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong>
        
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
        
   <div class="page-content">                 
     <div class="row page-row">
                       
       <div class="team-wrapper col-xs-12">        
         <div class="row page-row" >
          @if(isset($r))
          @if($r == "WITHDRAW")
        
          <h1 class="text-danger">Academic Standing : WITHDRAWN</h1>
          <p class="text-danger">You can not continue with these registeration.you have been withdrawn from the university.</p>
@elseif($r == "WITHDRAW OR CHANGE PROGRAMME")
          <h1 class=""></h1>
          <h1 class="text-danger">Academic Standing : WITHDRAWN OR CHANGE PROGRAMME</h1>
          <p class="text-danger">You can not continue with these registeration.you are advice to withdrawn or change your programme of study.<br/><strong>Contact Your Examination Officer or HOD for more explanation.</strong></p>

          @elseif($r == "PROBATION")
          <h3 class="text-danger">Academic Standing : {{$r}}</h3>
            <form class="form-horizontal" role="form" method="GET" action="{{ url('probation_semester_courses')}}" data-parsley-validate>
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
                        <select name="semester" class="form-control" required>
                            <option value="">-- Select Semester --</option>
                            @if(isset($semester))
                                @foreach($semester as $v)
                                    <option value="{{$v->semester_id}}">{{$v->semester_name}}</option>

                                @endforeach

                            @endif
                        </select>
                    </div>
                   <div class="col-sm-3">
                   <input type="submit" class="btn" value="Continue">
                   </div>

                </div>

            </form>

          @else
           <form class="form-horizontal" role="form" method="GET" action="{{ url('returning_register_semester_courses')}}" data-parsley-validate>
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
                        <select name="semester" class="form-control" required>
                            <option value="">-- Select Semester --</option>
                            @if(isset($semester))
                                @foreach($semester as $v)
                                    <option value="{{$v->semester_id}}">{{$v->semester_name}}</option>

                                @endforeach

                            @endif
                        </select>
                    </div>
                   <div class="col-sm-3">
                   <input type="submit" class="btn" value="Continue">
                   </div>

                </div>

            </form>
 @endif
          @endif
           
         </div>
       </div>
     </div>
   </div>
  </div>
</div>

@endsection