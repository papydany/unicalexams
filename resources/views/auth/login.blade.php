@extends('layouts.main')
@section('title','Login Page')
@section('content')
<div class="container content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<p class="text-danger text-center"><b>NB ::</b> PDS  and First Year students are categorise as <b>new students</b></p>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('matric_number') ? ' has-error' : '' }}">
                            <label  class="col-md-4 control-label">Matric Number</label>

                            <div class="col-md-6">
                                <input  type="text" class="form-control" name="matric_number" value="{{ old('matric_number') }}" required autofocus>

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
                                <input id="pin" type="text" class="form-control" name="pin" required>

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
                                <input  type="text" class="form-control" name="serial_number" required>

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
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Login
                                </button>

                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
