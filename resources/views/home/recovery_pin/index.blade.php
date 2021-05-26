@extends('layouts.main')
@section('title','Recovery Pin')
@section('content')
  <div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h1 class="heading-title pull-left">Recovery Pin</h1>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">Recovery Pint</li>
                        </ul>
                    </div><!--//breadcrumbs-->
                </header> 
                <div class="page-content">
                    <div class="col-sm-6">
                        <form  action="{{url('recovery_pin')}}" method="POST">
                                {{ csrf_field() }}
                                 <div class="s-12 form-group"><input name="matric_number" class="form-control" placeholder="Your Matric Number"  type="text" required /></div>
                                 <div class="s-12 form-group">
                                        <select class="form-control" name="session" required>
                                                  <option value=""> - - Select  Session- -</option>
                                                   
                                                      @for ($year = (date('Y')); $year >= 2016; $year--)
                                                      {{!$yearnext =$year+1}}
                                                      <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                                      @endfor
                                                    
                                                  </select>
                    
                                              
                                    </div>
                                    <div class="s-12 form-group"><input name="email" class="form-control" placeholder="Enter Intending Email Address To Receive The Pin"  type="email" required /></div>
                                
                                 <div class="s-12 m-12 l-4"><button class="btn btn-info" type="submit">Submit</button></div>
                               </form>
                            </div>
                    
                
                </div>
            </div><!--//page--> 
        </div><!--//content-->
@endsection