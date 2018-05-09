@extends('layouts.main')
@section('title','Edit Fos')
@section('content')
<div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
                    "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong></h1>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="url('/')}}">Edit FOS</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">Undergraduate</li>
                        </ul>
                    </div><!--//breadcrumbs-->
                </header> 
                <div class="page-content">                 
                    <div class="row page-row">                     
                        <div class="team-wrapper ">        
                            <div class="row page-row" >
                             <form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_fos') }}" data-parsley-validate> 
                               {{ csrf_field() }}  	
                            <div class="col-xs-12 col-sm-6">	
                            	<select class="form-control" name="fos" required>
                            		<option value="">-- Select --</option>
                            		@foreach($fs as $v)
                            		<option value="{{$v->id}}">{{$v->fos_name}}</option>

                            		@endforeach
                            	</select>
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