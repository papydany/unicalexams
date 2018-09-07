@extends('layouts.main')
@section('title','Edit Matric Number')
@section('content')
<div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
                    "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong><strong class="text-success">({{Auth::user()->matric_number}})</strong></h1>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="url('/')}}">Edit Matric Number</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">Undergraduate</li>
                        </ul>
                    </div><!--//breadcrumbs-->
                </header> 
                <div class="page-content">                 
                    <div class="row page-row">                     
                        <div class="team-wrapper ">        
                            <div class="row page-row" >
                             <form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_matric_number') }}" data-parsley-validate> 
                               {{ csrf_field() }}  	
                            <div class="col-xs-12">	
                                <h3 class="alert alert-success">Edit Matric Number</h3>
                            	     <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                          

                            <div class="col-sm-4">
                            <label for="matric_number">Old Matric_Number</label>
                                <input id="matric_number" type="text" class="form-control" name="oldmatric_number" value="{{ Auth::user()->matric_number }}" disabled>

                                @if ($errors->has('surname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>

                               <div class="col-sm-4">
                            <label for="matric_number">Enter Matric_Number</label>
                                <input id="matric_number" type="text" class="form-control" name="matric_number" value="" required>

                                @if ($errors->has('matric_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('matric_number') }}</strong>
                                    </span>
                                @endif
                            </div>
<br/>
                            	<input type="submit" name="" value="submit" class="btn">
                            </div>
                            </div>
                        </form>
                            </div>
                            
                          
                        </div><!--//team-wrapper-->
                    
                </div><!--//page-content-->
            </div><!--//page--> 
        </div><!--//content-->
    </div><!--//wrapper-->

@endsection