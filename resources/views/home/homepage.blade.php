@extends('layouts.main')
@section('title','Contact')
@section('content')
  <div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h1 class="heading-title pull-left">Home Page</h1>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">Home</li>
                        </ul>
                    </div><!--//breadcrumbs-->
                </header> 
                <div class="page-content">
                    <div class="col-sm-12 col-md-6" style="padding: 0;">
                    <div class='col-sm-6'>
                    <a href="https://unicalexams.edu.ng/newRegLogin" class="btn btn-info"> New Students Click Here </a>
                    </div>
                    <div class='col-sm-6'>
                   <!-- <a href="https://unicalexams.edu.ng/returning_register_course" class="btn btn-info"> Returning  Students Click Here</a>-->
                    <a href="https://unicalexams.edu.ng/oldlogin" class="btn btn-info"> Returning  Students Click Here</a>
                
                </div>
                  
                  </div>
                
                </div>
            </div><!--//page--> 
        </div><!--//content-->
@endsection