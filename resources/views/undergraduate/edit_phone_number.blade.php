@extends('layouts.main')
@section('title','Edit Phone Number')
@section('content')
<div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
                    "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong><strong class="text-success">({{Auth::user()->matric_number}})</strong></h1>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="url('/')}}">Edit Phone Number</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">Undergraduate</li>
                        </ul>
                    </div><!--//breadcrumbs-->
                </header> 
                <div class="page-content">                 
                    <div class="row page-row">                     
                        <div class="team-wrapper ">        
                            <div class="row page-row" >
                             <form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_phone_number') }}" data-parsley-validate> 
                               {{ csrf_field() }}  	
                            <div class="col-xs-12 ">
                                  <h3 class="alert alert-success">Edit Phone Number</h3>
                                   <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                          

                            <div class="col-sm-4">
                            <label for="firstname">Phone Number</label>
                                <input id="phone" type="number" class="form-control" name="phone" value="{{ Auth::user()->phone}}" required autofocus>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
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