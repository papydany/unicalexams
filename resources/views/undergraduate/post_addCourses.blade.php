@extends('layouts.main')
@section('title','Add Course ')
@section('content')
<div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
                    "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong></h1>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">Add Course </li>
                        </ul>
                    </div>
                </header> 
                </div>
                <div class="row" style="margin-bottom: 20px;">


                   

          <div class="table-responsive col-sm-12 col-md-10 col-md-offset-1">
           <p class="text-danger text-center"><b>ADD COURSES</b></p>
            <p class=" text-center" style="background-color: #0ff; padding: 10px"><b> Direct Entry students,  100 level, is your first year of three years programme</b></p>
            {{! $next_ss = $ss+1}}
                <p><b>Session :</b>{{$ss." / ".$next_ss }} </p>
                 <p><b>Level :</b>{{$l}}00 </p>
                  <p><b>Semester :</b>
                 @if(Auth::user()->programme_id == 4)
                  @if($s == 1)
              Contact 1
                  @elseif($s == 2)
                Contact 2
                  @endif
                 @else
                  @if($s == 1)
                  First 
                  @elseif($s == 2)
                  Second
                  @endif
                  @endif
                  </p>

                @if(isset($reg))
                 @if(count($reg) > 0)
          <p class="text-danger">Select the check box to choose the couress you want to add</p>     
          <form class="form-horizontal" role="form" method="POST" action="{{ url('/preview_addcourse') }}" data-parsley-validate>
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
                                       <input type="hidden" name="level" value="{{$l}}">
                                      <input type="hidden" name="semester" value="{{$s}}"> 
                                       <input type="hidden" name="crunit" value="{{$crunit}}">    
                                          {{!!$c = 0}}
                                        @foreach($reg as $v)
                                        {{!++$c}}
                                            @if(($c % 2)== 0)
                                            <tr>
                                            @else
                                            <tr class='danger'>
                                            @endif
                                            <td>{{$c}}</td>
                                                <td><input type="checkbox" name="id[]" value="{{$v->id}}">
 

                                                </td> 
                                                <td>{{strtoupper($v->reg_course_title)}}</td>
                                                <td>{{strtoupper($v->reg_course_code)}}</td>
                                                  <td>{{$v->reg_course_unit}}</td>
                                                <td>{{$v->reg_course_status}}</td>
                                            </tr>
                                         @endforeach   
                                           
                                        </tbody>
                                    </table><!--//table-->
                         

                           <div class="col-sm-offset-8 col-sm-4">
                                   
                                <button type="submit" class="btn btn-lg">
                                    <i class="fa fa-btn fa-user"></i> Preview
                                </button>
                            </div>
                                </form>
                             

                                @else
                         <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert">
     No course is avalable for registeration in these semester. Contact your examination Officer or send a message  throuh mail.<br/>
     <strong>Thank you.... Unical exam portal Admin</strong>
    </div>       
                                @endif
                                 @endif
                                 </div>
                </div>
                </div>
@endsection