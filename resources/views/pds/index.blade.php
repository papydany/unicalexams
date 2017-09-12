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
                            <li class="current">PDS</li>
                        </ul>
                    </div><!--//breadcrumbs-->
                </header> 
                <div class="page-content">                 
                    <div class="row page-row">                     
                        <div class="team-wrapper col-xs-12">        
                            <div class="row page-row" >
                              
                             
                                 <div class="col-sm-7">
                               
                         <div class="col-xs-8">
                        <p><strong class="text-danger">Martic Number : </strong>{{Auth::user()->matric_number}}</p>
                     
                   
                      <p><strong class="text-danger">Phone Number : </strong>{{Auth::user()->phone}}</p>
                        <p><strong class="text-danger">Email : </strong>{{Auth::user()->email}}</p>
                         <p><strong class="text-danger">Entry year : </strong>{{Auth::user()->entry_year}}</p>
                        </div>
                           <figure class="thumb col-md-3 col-sm-4 col-xs-4">
                                    <img class="img-responsive" src="{{asset('img/pdg_student/'.Auth::user()->image_url)}}" alt="" />
                                </figure>
                                </div>                               
                            </div>
                            
                          
                        </div><!--//team-wrapper-->
                    
                </div><!--//page-content-->
            </div><!--//page--> 
        </div><!--//content-->
    </div><!--//wrapper-->
@endsection