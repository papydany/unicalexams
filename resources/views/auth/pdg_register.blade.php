@extends('layouts.main')
@section('title','Registeration')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">PDS BIO DATA</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url('pdg_register')}}""  enctype="multipart/form-data" data-parsley-validate">
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
                                <input id="name" type="text" class="form-control" name="othername" value="{{ old('name') }}" required>

                                @if ($errors->has('othername'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('othername') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                          

                            <div class="col-sm-4">
                            <label for="matric_number">Matric Number(PDS Number)</label>
                           <?php $jreg= session()->get('jreg'); ?>
                             <input  type="hidden" class="form-control" name="jamb_reg" value="{{$jreg}}">
                                <input id="matric_number" type="text" class="form-control" name="matric_number" value="{{ old('matric_number') }}" required>

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
                                 <label for="student_type">PDS Type</label>
                                <select class="form-control" name="student_type">
                                    <option value="">Select</option>
                                    
                                    <option value="1">Science</option>
                                    <option value="2">Mordern Language</option>

                                  
                                </select>
                                </div>
                               
    <div class="col-sm-4">
                              <label for="session" class=" control-label">  Session</label>
                              <select class="form-control" name="entry_year" required>
                              <option value=""> - - Select - -</option>
                               
                                  @for ($year = (date('Y')); $year >= 2016; $year--)
                                  {{!$yearnext =$year+1}}
                                  <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                  @endfor
                                
                              </select>
                             
                            </div>
                      
  <div class="col-sm-4">
                              <label for="address" class="control-label"> Contact Address</label>
                              <textarea class="form-control" name="address" cols="5"></textarea>
                               
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
                              <label for="marital_status" class=" control-label"> Marita Status</label>
                              <select class="form-control" name="marital_status" required>
                              <option value=""> - - Select - -</option>
                              <option value="Single">Single</option>
                                  <option value="Married">Married</option>
                                  <option value="Devioced">Devioced</option>
                                </select>
                             
                            </div>

                               <div class="col-sm-4">
                              <label for="entry_month" class=" control-label">Passport ( <span class="text-danger">Max size 200 * 200)</label>
                            <input type="file" name="image_url" class="form-control">
                             
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
   