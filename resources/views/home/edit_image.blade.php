@extends('layouts.main')
@section('title','Edit Image')
@section('content')
  <div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h1 class="heading-title pull-left">Edit Images</h1>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">Edit Images</li>
                        </ul>
                    </div><!--//breadcrumbs-->
                </header> 
                <div class="page-content">
                    <div class="col-sm-12" style="padding: 0;">
                        <form class="form-horizontal" role="form" method="POST" action="{{url('edit_imagerrrrrrr98888880')}}""  enctype="multipart/form-data" data-parsley-validate">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$u->id}}">

                             <div class="col-sm-4">
                              <label for="entry_month" class=" control-label">Passport ( <span class="text-danger">Max size 200 * 200)</span></label>
                            <input type="file" name="image_url" class="form-control">
                             
                            </div>
                            <div class="col-sm-4">
                                <br/>
                                <input type="submit" name="" value="Update" class="btn btn-warning">
                            </div>
                        </form>
  </div> 
                </div>
            </div><!--//page--> 
        </div><!--//content-->
@endsection                       