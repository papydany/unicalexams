@extends('layouts.main')
@section('title','Preview Course ')
@section('content')
   <div class="content container">
        <div class="page-wrapper">
            <header class="page-heading clearfix">
                <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
         
                    "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong></h1>
                <div class="breadcrumbs pull-right">
                    <ul class="breadcrumbs-list">
                        <li class="breadcrumbs-label">You are here:</li>
                        <li><a href="url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                        <li class="current">No Result</li>
                    </ul>
                </div><!--//breadcrumbs-->
            </header>
        </div>
 <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
  Your Result is not ready. Please Contact your examination officer for more clirification
    </div>


        </div>

@endsection