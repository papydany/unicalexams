@extends('layouts.main')
@section('title','Login Page')
@section('content')
<div class="container content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
                <h3 class="text-center alert alert-danger" role="alert" >

                        Student That Entered Schools in 2015/2016 and below  <a href="{{url('std_login')}}" class="btn btn-md">Click Here </a> to check Your Result</h3>
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
 <h5 class="text-center alert alert-success" role="alert" >
     Student That Entered Schools in 2016/2017 and Above </h5>
<br/>
<h4 class="text-success text-center"><b>NB ::</b>First Year students are categorise as <b>new students</b></h4>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('matric_number') ? ' has-error' : '' }}">
                            <label  class="col-md-4 control-label">Matric Number</label>

                            <div class="col-md-6">
                                <input  type="text" class="form-control" name="matric_number" value="{{ old('matric_number') }}" required autofocus autocomplete="off">

                                @if ($errors->has('matric_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('matric_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('pin') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Pin</label>

                            <div class="col-md-6">
                                <input id="pin" type="text" class="form-control" name="pin" autocomplete="off" required>

                                @if ($errors->has('pin'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pin') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                          <div class="form-group{{ $errors->has('serial_number') ? ' has-error' : '' }}">
                            <label  class="col-md-4 control-label">Serial Number</label>

                            <div class="col-md-6">
                                <input  type="text" class="form-control" name="serial_number" autocomplete="off" required>

                                @if ($errors->has('serial_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('serial_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label  class="col-md-4 control-label">Student Type</label>

                            <div class="col-md-6">
                          <select name="type" class="form-control" required>
                          <option value="">  -- select -- </option>
                              <option value="1~0">PDS</option>
                              <option value="2~1">Undergraduate (Direct Entry)</option>
                              <option value="2~2">Undergraduate (Other)</option>
                              <option value="2~3">Affiliate Institutions Students</option>
                          </select>

                               
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label  class="col-md-4 control-label">Student Status</label>
                             <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="status" value="1">New Students</label>
                            <label class="radio-inline"><input type="radio" name="status" value="2">Returning Students</label>
                        </div>
                        </div>

                  

                        <div class="form-group">
                            <div class="col-xs-4 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Login
                                </button>
                            </div>
                            <div class="col-xs-4">
                                  <!--  <a href="{{url('recovery_pin')}}" class="btn btn-success btn-lg">
                                        Recovery Pin
                                    </a>-->
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
