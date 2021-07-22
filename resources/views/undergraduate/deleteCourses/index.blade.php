@extends('layouts.main')
@section('title','Delete Course ')
@section('content')
    <div class="content container">
        <div class="page-wrapper">
            <header class="page-heading clearfix">
                <h4 class="text-center text-primary"><b><u>DELETE COURSES</u></b></h4>
                
                <h4 class="heading-title pull-left"><strong class=''>{{ strtoupper(Auth::user()->surname.
         
                    " ". Auth::user()->firstname." ".Auth::user()->othername )}}</strong>
                    <strong class="text-primary">{{Auth::user()->matric_number}}</strong></h4>
                <div class="breadcrumbs pull-right">
                    <ul class="breadcrumbs-list">
                        <li class="breadcrumbs-label">You are here:</li>
                        <li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                        <li class="current">Delete Courses </li>
                    </ul>
                </div><!--//breadcrumbs-->
            </header>
        </div>
        <div class="row" style="margin-bottom: 20px;">
            <form class="form-horizontal" role="form" method="POST" target="_blank" action="{{ url('/deleteCourses') }}" data-parsley-validate>
            {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-3">
                       
                        <select name="session"   class="form-control">
                            <option value="">-- Select Session --</option>
                            @if(isset($studentreg))
                           
                            {{!$next = $studentreg->session + 1}}
                            <option value="{{$studentreg->session}}">{{$studentreg->session." / ".$next}} session</option>
                           
                        
                            @endif
                        </select>
                     
                    </div>
                    <div class="col-sm-3">
                        <select name="level" class="form-control" required>
                            <option value="">-- Select Level --</option>
                            @if(isset($studentreg))
                            {{$i = 1}}
                           
                            
                            @if(Auth::user()->faculty_id == 14 &&  $studentreg->level_id < 7)
                            @if($studentreg->level_id < 3)

                            <option value="{{$studentreg->level_id}}">{{$studentreg->level_id}}00</option>
                          
                            @else
                            <option value="{{$studentreg->level_id}}">PART {{$i++}}</option>
                          
                            @endif
                             @if($studentreg->level_id == 6)
                             
                               @endif
                            @else
                                <option value="{{$studentreg->level_id}}">{{$studentreg->level_id}}00</option>
                            @endif
                           
                         
                            @endif
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <select name="semester" class="form-control" required>
                            <option value="">-- Select Semester --</option>
                            @if(isset($s))
                                @foreach($s as $v)
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

    </div>
    </div>
@endsection