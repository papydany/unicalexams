@extends('layouts.main')
@section('title','Contact')
@section('content')
  <div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h1 class="heading-title pull-left">Contact Us</h1>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">Contact</li>
                        </ul>
                    </div><!--//breadcrumbs-->
                </header> 
                <div class="page-content">
                    <div class="col-sm-12 col-md-6" style="padding: 0;">
                     <h3 class="text-danger">Email Us</h3>
                     <address>


                
                        <p><strong class="text-info">E-mail:</strong>contact@unicalexams.edu.ng</p>
                     </address>
                     <br />
                     <h3 class="text-danger">Social</h3>
                     <p><i class="icon-facebook icon"></i> <a href="#">Facebook</a></p>
                    
                     <p class="margin-bottom"><i class="icon-twitter icon"></i> <a href="#" >Twitter</a></p>

                       <p class="margin-bottom"><i class="icon-linkedin icon"></i> <a href="#">Linkedin</a></p>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <h3 class="text-danger"> contact form </h3>
                    <form  action="{{url('contact')}}" method="POST">
                     {{ csrf_field() }}
                      <div class="s-12 form-group"><input name="email" class="form-control" placeholder="Your e-mail" title="Your e-mail" type="email" /></div>
                      <div class="s-12 form-group"><input name="phone" class="form-control" placeholder="Your Phone Number" title="Your phone Number" type="number" /></div>
                      <div class="s-12 form-group"><input name="matric_number" placeholder="Your Matric Number" class="form-control" title="Your matric Number" type="text" /></div>
                      <div class="s-12 form-group"><textarea placeholder="Your massage" class="form-control" name="message" rows="5"></textarea></div>
                      <div class="s-12 m-12 l-4"><button class="btn btn-info" type="submit">Submit</button></div>
                    </form>
                  </div> 
                </div>
            </div><!--//page--> 
        </div><!--//content-->
@endsection