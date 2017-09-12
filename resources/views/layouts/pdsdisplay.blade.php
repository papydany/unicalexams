<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
 <html lang="en"> 
<head>
  @include('partial._header')
    <link rel="stylesheet" href="{{URL::to('assets/plugins/bootstrap/css/bootstrap.min.css')}}" media="all"> 
</head> 
<style type="text/css">
@media print {
   .w{width: 20%;float:left;}
        .w1{width: 60%;float:left;}
        .ww{width: 20%;float:right;}


}
</style>
<body class="home-page">
   <div class="content container">
    <div class="row">
    <div class="col-xs-12" style="padding-top: 10px;padding-bottom:10px;">
    <div class="col-sm-2 w"><img id="logo" src="{{asset('assets/images/logo.png')}}" alt="Logo">
    </div>
  
<div class="col-sm-8 w1 text-center">
    <h4><b>UNIVERSITY OF CALABAR CALABAR</b></h4>
    <p>DIRECTORATE OF PRE-DEGREE PROGRAMME</p>
    <?php $next = $ss+1; ?>
  <p class="text-danger">{{$ss.' / '.$next}} ACADEMIC SESSION</p>


  </div>
   <div class="col-sm-2 ww">  <img class="img-responsive" src="{{asset('img/pdg_student/'.Auth::user()->image_url)}}" alt="" /></div>
  </div>
  </div>
  
 @yield('content')
 
 </div><!--//wrapper-->
    
 
    @include('partial._script')   

 </body>


</html>             