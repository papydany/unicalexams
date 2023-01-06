@extends('layouts.app')
@section('title','Login')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3" style="margin-top:70px;">
          <h2 class="text-danger">NB</h2>
          <p class="text-danger">Students will need scanned or soft copy passport for online profile registration  </p>
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                 @include('partial._message')  
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/enter_pin') }}" data-parsley-validate>
                        {{ csrf_field() }}

                         <div class="form-group{{ $errors->has('matricno') ? ' has-error' : '' }}">
                            <label for="matricno" class="col-sm-4 control-label">Jamb Reg Number / Matric Number</label>

                            <div class="col-sm-6">
                                <input id="matricno" type="text" class="form-control" name="matricno" data-parsley-required placeholder="Reg number used in paying  fess">

                                @if ($errors->has('matricno'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('matricno') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <div class="form-group{{ $errors->has('session') ? ' has-error' : '' }}">
                            <label for="session" class="col-sm-4 control-label">Session</label>

                            <div class="col-sm-6">
                                <select class="form-control" name="session" data-parsley-required>
                              <option value=""> - - Select - -</option>
                               
                                  @for ($year = 2019; $year >= 2009; $year--)
                                  {{!$yearnext =$year+1}}
                                  <option value="{{$year.'/'.$yearnext.'~'.$year}}">{{$year.'/'.$yearnext}}</option>
                                  @endfor
                                
                              </select>

                            </div>
                        </div>
                         <div class="form-group{{ $errors->has('student_type') ? ' has-error' : '' }}">
                            <label for="student_type" class="col-sm-4 control-label">Student Type</label>

                            <div class="col-sm-6">
                                 <select class="form-control" name="student_type" data-parsley-required>
                              <option value=""> - - Select - -</option>
                               
                                  <option value="2">Direct Entry Students</option>
                                  <option value="1">Other Students</option>
                                  <option value="3">Affiliate Institutions Students</option>
                          
                                
                              </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('pin') ? ' has-error' : '' }}">
                            <label for="pin" class="col-sm-4 control-label">Pin</label>

                            <div class="col-sm-6">
                                <input id="pin" type="text" class="form-control" name="pin" data-parsley-required>

                                @if ($errors->has('pin'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pin') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                          <div class="form-group{{ $errors->has('serial_no') ? ' has-error' : '' }}">
                            <label for="serial_no" class="col-sm-4 control-label">Serial number</label>

                            <div class="col-sm-6">
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
