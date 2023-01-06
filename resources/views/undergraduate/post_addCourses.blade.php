@extends('layouts.main')
@section('title','Add Course ')
@section('content')
<div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h4 class="text-center text-primary"><b>Add COURSES</b></h4>
                
                <h4 class="heading-title pull-left"><strong class=''>{{ strtoupper(Auth::user()->surname.
         
                    " ". Auth::user()->firstname." ".Auth::user()->othername )}}</strong>
                    <strong class="text-primary">{{Auth::user()->matric_number}}</strong></h4>
                <div class="breadcrumbs pull-right">
                    <ul class="breadcrumbs-list">
                        <li class="breadcrumbs-label">You are here:</li>
                        <li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                        <li class="current">Add Courses </li>
                    </ul>
                </div><!--//breadcrumbs-->
                </header> 
                </div>
                <div class="row" style="margin-bottom: 20px;">


                   

          <div class="table-responsive col-sm-12">
          
            <p class="text-center" style="background-color: rgb(255, 81, 0); padding: 5px;color:white"><b> Direct Entry students,  100 level, is your first year of three years programme</b></p>
            {{! $next_ss = $ss+1}}
                <h4><b>Session :</b>{{$ss." / ".$next_ss }} </h4>
                 <h4><b>Level :</b>{{$l}}00 </h4>
                  <h4><b>Semester :</b>
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
                  </h4>

                @if(isset($reg))
                 @if(count($reg) > 0)
          <h4 class="text-danger text-center">Select the check box to choose the couress you want to add</h4>     
          <form class="form-horizontal" role="form" method="POST" action="{{ url('preview_addcourse') }}" data-parsley-validate>
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
                                     <input type="hidden" name="session" value="{{$ss}}">
                                       <input type="hidden" name="level" value="{{$l}}">
                                      <input type="hidden" name="semester" value="{{$s}}"> 
                                       <input type="hidden" name="crunit" value="{{$crunit}}">    
                                          {{!!$c = 0}}
                                        @foreach($reg as $v)
                                        {{!++$c}}
                                            @if(($c % 2)== 0)
                                            <tr>
                                            @else
                                            <tr class='success'>
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
     No course is available to Add in these semester. Contact your examination Officer or send a message  using our email.<br/>
     <strong>Thank you.... university of Calabar Exams portal Admin</strong>
    </div>       
                                @endif
                                 @endif
                                 </div>
                </div>
                </div>
@endsection