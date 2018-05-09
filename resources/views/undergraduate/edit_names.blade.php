@extends('layouts.main')
@section('title','Edit Names')
@section('content')
<div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
                    "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong></h1>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="url('/')}}">Edit Names</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">Undergraduate</li>
                        </ul>
                    </div><!--//breadcrumbs-->
                </header> 
                <div class="page-content">                 
                    <div class="row page-row">                     
                        <div class="team-wrapper ">        
                            <div class="row page-row" >
                             <form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_names') }}" data-parsley-validate> 
                               {{ csrf_field() }}  	
                            <div class="col-xs-12 ">
                                  <h3 class="alert alert-success">Edit Names</h3>
                                   <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                          

                            <div class="col-sm-4">
                            <label for="firstname">Surname</label>
                                <input id="surname" type="text" class="form-control" name="surname" value="{{ Auth::user()->surname }}" required autofocus>

                                @if ($errors->has('surname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>

                               <div class="col-sm-4">
                            <label for="firstname">First Name</label>
                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ Auth::user()->firstname}}" required>

                                @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            </div>

                               <div class="col-sm-4">
                            <label for="othername">OtherName</label>
                                <input id="name" type="text" class="form-control" name="othername" value="{{ Auth::user()->othername}}">

                                @if ($errors->has('othername'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('othername') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>	
                            	
                            	<br/>
                            	<input type="submit" name="" value="submit" class="btn">
                            </div>
                        </form>
                            </div>
                            
                          
                        </div><!--//team-wrapper-->
                    
                </div><!--//page-content-->
            </div><!--//page--> 
        </div><!--//content-->
    </div><!--//wrapper-->

@endsection