@extends('layouts.main')
@section('title','Registeration')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">UNDERGRADUATE BIO DATA</div>
                <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{url('newregister')}}"  enctype="multipart/form-data" data-parsley-validate">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                          

                            <div class="col-sm-4">
                            <label for="firstname">Surname</label>
                                <input type="text" class="form-control" value="{{$u->surname}}" readonly>

                               
                            </div>

                               <div class="col-sm-4">
                            <label for="firstname">First Name</label>
                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{$u->firstname }}" readonly>

   
                            </div>

                               <div class="col-sm-4">
                            <label for="othername">OtherName</label>
                                <input id="name" type="text" class="form-control" name="othername" value="{{ $u->othername }}" readonly>

                              
                            </div>
                        </div>

                        <div class="form-group">
                          

                            <div class="col-sm-4">
                            <label for="matric_number">Matric Number</label>
                          
                             
                                <input id="matric_number" type="text" class="form-control" name="matric_number" value="{{$u->matric_number}}" readonly>

                            </div>

                               <div class="col-sm-4">
                            <label for="Phone">Phone</label>
                                <input  type="text" class="form-control" name="phone" value="{{ old('Phone') }}" required>

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
                          <div class="col-sm-3">
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

                       <div class="col-sm-3">
                                 <label for="faculty">Faculty</label>
                                 @if($u->faculty_id != null)

                                 @else
                                <select class="form-control" name="faculty_id" id="faculty">
                                    <option value="">Select</option>
                                    @if(isset($f))
                                    @foreach($f as $v)
                                    @if($v->id != 6)
                                    
                                    <option value="{{$v->id}}">{{$v->faculty_name}}</option>
                                    @endif

                                    @endforeach

                                    @endif
                                </select>
                               
                                </div>

                                <div class="col-sm-3">
                              <label for="password-confirm" >Department</label>
                              <select class="form-control" name="department_id" id="department" required>
                             </select>
                             <div class="col-sm-3">
                                 <label for="faculty">Field Of Study</label>
                                  <select class="form-control" name="fos_id" id="fos" required>
                             </select>
                                </div>
                                @endif
                               
                            </div>

                        </div>
                          <div class="form-group">
                          <div class="col-sm-4">
                                 <label for="faculty">Field Of Study</label>
                                  <select class="form-control" name="fos_id" id="fos" required>
                             </select>
                                </div>
                                <div class="col-sm-4">
                             <br/>
                             
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Submit
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
  