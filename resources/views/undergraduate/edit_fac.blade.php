@extends('layouts.main')
@section('title','Edit Faculty')
@section('content')
<div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
                    "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong><strong class="text-success">({{Auth::user()->matric_number}})</strong></h1>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="url('/')}}">Edit Faculty</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">Undergraduate</li>
                        </ul>
                    </div><!--//breadcrumbs-->
                </header> 
                <div class="page-content">                 
                    <div class="row page-row">                     
                        <div class="team-wrapper ">        
                            <div class="row page-row" >
                             <form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_fac') }}" data-parsley-validate> 
                               {{ csrf_field() }}  	
                            <div class="col-xs-12 col-sm-6">
                                <input type="hidden" name="programme" id="programme" value="{{Auth::user()->programme_id}}">
                            <label for="faculty">Faculty</label>	
                            	<select class="form-control" name="faculty" id="fac" required>
                            		<option value="">-- Select --</option>
                            		@foreach($fs as $v)
                            		<option value="{{$v->id}}">{{$v->faculty_name}}</option>

                            		@endforeach
                            	</select>
                               <br/>
                              <label for="password-confirm" >Department</label>
                              <select class="form-control" name="department" id="dept" required>
                             </select>

                          <br/>
                                 <label for="faculty">Field Of Study</label>
                                  <select class="form-control" name="fos" id="fos" required>
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
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
       
        <div class="modal-body text-danger text-center">
          <p>... processing ...</p>
        </div>
       
      </div>
      
    </div>
  </div>
@endsection