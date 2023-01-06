@extends('layouts.main')
@section('title','Register Course ')
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
        </div>
        <div class="row col-md-6" style="margin-bottom: 20px;">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('returningRegisterCourse') }}" data-parsley-validate>
            {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-8 m10px">
                       
                        <select name="session"   class="form-control" required>
                            <option value="">-- Select Session --</option>
                           @if(Auth::user()->faculty_id == 14 || Auth::user()->faculty_id == 10 )
                           @for ($year = 2021; $year >= 2009; $year--)
                            {{!$yearnext =$year+1}}
                            <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                            @endfor
                           @else
                            @for ($year = 2021; $year >= 2020; $year--)
                            {{!$yearnext =$year+1}}
                            <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                            @endfor
                           @endif
                        
                        </select>
                     
                    </div>
                   

                
                   <div class="col-sm-3 m10px">
                   <input type="submit" class="btn" value="Continue">
                   </div>

                </div>

            </form>

    </div>
    <div class="col-md-6">
        <h5 class="text-center text-primary"><b><u> STUDENTS  COURSE REGISTRATION HISTORY</u></b></h5>
        <table class="table table-boxed">
            <thead>
              <tr>
                 <th>#</th>
                 <th>Session</th>
                 <th>level</th>
                 <th>Semester</th>
                 <th>Status</th>
             </tr>
         </thead>
        <tbody>
            {{!!$c = 0}}
            @foreach($allstudentreg as $vf)
            {{!++$c}}
            @if(($c % 2)== 0)
                <tr>
            @else
              <tr class='success'>
            @endif
            <td>{{$c}}</td>
            
            <td>{{strtoupper($vf->session)}}</td>
            <td>{{strtoupper($vf->level_id)}}</td>
            <td>@if($vf->semester == 1)
           First
                
            @else
            Second
                
            @endif</td>
            <td>{{$vf->season}}</td>
            </tr>
        @endforeach 
        </tbody>
        </table>
                
              
    </div>
    </div>
@endsection