@extends('layouts.main')
@section('title','Login Page')
@section('content')
<div class="container content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
              
                       
 
            <div class="panel panel-default" style="margin-top: 80px;margin-bottom: 100px;">
                <div class="panel-heading">
                <h4 class="text-center">New Students Login</h4></div>
                <div class="panel-body">
                @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif


                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('matric_number') ? ' has-error' : '' }}">
                            <label  class="col-md-4 control-label">Matric Number</label>

                            <div class="col-md-6">
                                <input  type="text" class="form-control" autocomplete="off" name="matric_number" value="{{ old('matric_number') }}" required autofocus autocomplete="off">

                                @if ($errors->has('matric_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('matric_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('pin') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Jamb Reg Number</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="password" autocomplete="off" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label  class="col-md-4 control-label">Student Type</label>

                            <div class="col-md-6">
                          <select name="type" class="form-control" required>
                          <option value="">  -- select -- </option>
                              <option value="2~1">Undergraduate (Direct Entry)</option>
                              <option value="2~2">Undergraduate (Other)</option>
                            
                          </select>

                               
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label  class="col-md-4 control-label">Student Status</label>
                             <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="status" value="1">New Students</label>
                           <!-- <label class="radio-inline"><input type="radio" name="status" value="2">Returning Students</label>-->
                        </div>
                        </div>

                  

                        <div class="form-group">
                            <div class="col-xs-12 col-md-4 col-md-offset-4" style="margin-bottom:6px;" >
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                          <!--  <div class="col-xs-12 col-md-4">
                                   <a href="{{url('password/reset')}}" class="btn btn-success">
                                        Forgotten Password ?
                                    </a>
                                </div>-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
