@extends('layouts.main')
@section('title','Registeration')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">UNDERGRADUATE BIO DATA</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('register')}}""  enctype="multipart/form-data" data-parsley-validate">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                          

                            <div class="col-sm-4">
                            <label for="firstname">Surname</label>
                                <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}" required autofocus>

                                @if ($errors->has('surname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>

                               <div class="col-sm-4">
                            <label for="firstname">First Name</label>
                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('name') }}" required>

                                @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            </div>

                               <div class="col-sm-4">
                            <label for="othername">OtherName</label>
                                <input id="name" type="text" class="form-control" name="othername" value="{{ old('name') }}">

                                @if ($errors->has('othername'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('othername') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                          

                            <div class="col-sm-4">
                            <label for="matric_number">Matric Number</label>
                             <?php $jreg= session()->get('jreg'); ?>
                             <input  type="hidden" class="form-control" name="jamb_reg" value="{{$jreg}}">
                                <input id="matric_number" type="text" class="form-control" name="matric_number" value="{{ old('matric_number') }}" required autofocus>

                                @if ($errors->has('matric_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('matric_number') }}</strong>
                                    </span>
                                @endif
                            </div>

                               <div class="col-sm-4">
                            <label for="Phone">Phone</label>
                                <input id="firstname" type="text" class="form-control" name="phone" value="{{ old('Phone') }}" required>

                                @if ($errors->has('Phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Phone') }}</strong>
                                    </span>
                                @endif
                            </div>

                               <div class="col-sm-4">
                            <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('name') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-4">
                                 <label for="programme">Programm</label>
                                <select class="form-control" name="programme_id" id='programme'>
                                    <option value="">Select</option>
                                    @if(isset($p))
                                    @foreach($p as $v)
                                    <option value="{{$v->id}}">{{$v->programme_name}}</option>

                                    @endforeach

                                    @endif
                                </select>
                                </div>

                       <div class="col-sm-4">
                                 <label for="faculty">Faculty</label>
                                <select class="form-control" name="faculty_id" id="faculty">
                                    <option value="">Select</option>
                                    @if(isset($f))
                                    @foreach($f as $v)
                                    <option value="{{$v->id}}">{{$v->faculty_name}}</option>

                                    @endforeach

                                    @endif
                                </select>
                                </div>

                                <div class="col-sm-4">
                              <label for="password-confirm" >Department</label>
                              <select class="form-control" name="department_id" id="department" required>
                             </select>

                               
                            </div>

                        </div>
                          <div class="form-group">
                          <div class="col-sm-4">
                                 <label for="faculty">Field Of Study</label>
                                  <select class="form-control" name="fos_id" id="fos" required>
                             </select>
                                </div>
                                   <div class="col-sm-4">
                              <label for="session" class=" control-label"> Entry Session</label>
                              <select class="form-control" name="entry_year" required>
                              <option value="{{session()->get('session')}}">{{session()->get('session')}}</option>
                              </select>
                             
                            </div>

                               <div class="col-sm-4">
                              <label for="entry_month" class=" control-label">Entry Month</label>
                              <select class="form-control" name="entry_month" id="entry_month">
                              <option value="0">january</option>
                               
                                
                                
                              </select>
                             
                            </div>
                                </div>
                           <div class="form-group">
                          <div class="col-sm-4">
                                 <label for="faculty">Gender</label>
                                  <select class="form-control" name="gender" required>
                                  <option value="">-- select --</option>
                                  <option value="male">male</option>
                                  <option value="female">Female</option>
                             </select>
                                </div>
                                   <div class="col-sm-4">
                              <label for="marital_status" class=" control-label"> Marital Status</label>
                              <select class="form-control" name="marital_status" required>
                              <option value=""> - - Select - -</option>
                              <option value="Single">Single</option>
                                  <option value="Married">Married</option>
                                  <option value="Devioced">Devioced</option>
                                </select>
                             
                            </div>

                               <div class="col-sm-4">
                              <label for="entry_month" class=" control-label">Passport ( <span class="text-danger">Max size 200 * 200)</label>
                            <input type="file" name="image_url" class="form-control" required>
                             
                            </div>
                                </div>      

                        <div class="form-group">
                       <div class="col-sm-4">
                         <label for="state_id">Nationality</label>
                                <input  type="text" class="form-control" name="nationality" required>

                                               </div>
                            <div class="col-sm-4">
                               <label for="state_id">State</label>
                                 <select class="form-control" name="state_id" id="state" required>
                      
                         <option value="">Select State</option>
                         @foreach($s as $value)
                           <option value="{{$value->id}}">{{$value->state_name}}</option>
                         @endforeach   
                         </select>

                          </div>

                      
                          

                            <div class="col-sm-4">
                              <label for="password-confirm" >LGA</label>
                              <select class="form-control" name="lga_id" id="lga" required>
                        
                          
                         </select>

                               
                            </div>
                        </div>
                        

                        <div class="form-group">
                          

                            <div class="col-sm-6">
                              <label for="address" class="control-label">Address</label>
                              <textarea class="form-control" name="address" cols="5"></textarea>
                               
                            </div>
                             <div class="col-sm-4 col-sm-offset-2">
                             <br/>
                             <br/>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Register
                                </button>
                            </div>
                        </div>

                      
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
</div>
  
@endsection
  