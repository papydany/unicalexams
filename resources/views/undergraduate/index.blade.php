@extends('layouts.main')
@section('title','Home')
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
                            <li class="current">Undergraduate</li>
                        </ul>
                    </div><!--//breadcrumbs-->
                 
                </header> 
                {{!$next =$ss+1}}
           <h3><strong class="text-success">PIN VALID FOR &nbsp; {{$ss." / ".$next}} &nbsp; SESSION</strong></h3>
                <div class="page-content">                 
                    <div class="row page-row">                     
                        <div class="team-wrapper col-xs-12">        
                            <div class="row page-row" >
                              
                             
                              
                               
                         <div class="col-sm-7 table-responsive">
                          <table class="table table-bordered table-striped">
                            <tr>
                              <th class="text-danger">Matric Number </th>
                              <td>{{Auth::user()->matric_number}}</td>
                            </tr>
                            <tr>
                              <th class="text-danger">Programme</th>
                              <td>{{$p->programme_name}}</td>
                            </tr>
                            <tr>
                              <th class="text-danger">Faculty</th>
                              <td>{{$f->faculty_name}}</td>
                            </tr>
                            <tr>
                              <th class="text-danger">Department</th>
                              <td>{{$d->department_name}}</td>
                            </tr>
                            <tr>
                              <th class="text-danger">Field of Study</th>
                              <td>{{$fs->fos_name}}</td>
                            </tr>
                            <tr>
                              <th class="text-danger">Phone Number</th>
                              <td>{{Auth::user()->phone}}</td>
                            </tr>
                             <tr>
                              <th class="text-danger">Email</th>
                              <td>{{Auth::user()->email}}</td>
                            </tr>
                             <tr>
                              <th class="text-danger">Entry year</th>
                              <td>{{Auth::user()->entry_year}}</td>
                            </tr>

                          </table>

                   
                        </div>
                           <div class="col-sm-5">
                         
                                    <img class="img-responsive" src="{{asset('img/student/'.Auth::user()->image_url)}}" alt="" style="float: right;"/>
                                  @if(isset($sreg))
                          @if(count($sreg) == 0)
                         <p> <a href="{{url('edit_fos')}}" class="btn">Edit Field Of Studies</a></p>
                         <p> <a href="{{url('edit_fac')}}" class="btn">Edit Faculty / Depart</a></p>
                         @endif
                         @endif    
                                <p> <a href="{{url('edit_matric_number')}}" class="btn">Edit Matric Number&nbsp;&nbsp;&nbsp;</a></p>
                                 <p> <a href="{{url('edit_names')}}" class="btn">Edit Your Names &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></p>
                                </div>                               
                            </div>
                            
                          
                        </div><!--//team-wrapper-->
                    
                </div><!--//page-content-->
            </div><!--//page--> 
        </div><!--//content-->
    </div><!--//wrapper-->

@endsection