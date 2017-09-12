@extends('layouts.app')
@section('title','Login')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                 @include('partial._message')  
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/std_login') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('matric_no') ? ' has-error' : '' }}">
                              <input type="hidden" name="student_type" value="3">
                            <label for="matric_no" class="col-md-4 control-label">Matric Number</label>

                            <div class="col-md-6">
                                <input id="matric_no" type="text" class="form-control" name="matric_no" value="{{ old('matric_no') }}" data-parsley-required>

                                @if ($errors->has('matric_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('matric_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('pin') ? ' has-error' : '' }}">
                            <label for="pin" class="col-md-4 control-label">Pin</label>

                            <div class="col-md-6">
                                <input id="pin" type="text" class="form-control" name="pin" data-parsley-required>

                                @if ($errors->has('pin'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pin') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                          <div class="form-group{{ $errors->has('serial_no') ? ' has-error' : '' }}">
                            <label for="serial_no" class="col-md-4 control-label">Serial number</label>

                            <div class="col-md-6">
                                <input id="serial_no" type="text" class="form-control" name="serial_no" data-parsley-required>

                                @if ($errors->has('serial_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('serial_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

            
                       
                        
            
           


                   

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
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
