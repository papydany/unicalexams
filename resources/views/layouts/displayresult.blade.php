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
.w{width: 400px;
float: left;}
.w2{width: 500px;float: left;clear:all;}
.w3{width: 800px;float: left;}
.w4{width: 1000px;float: left;}
}
</style>
<body class="home-page">
   <div class="content container">
    <div class="row">
    <div class="col-xs-12" style="padding-top: 10px;padding-bottom:10px;">
    <div class="col-sm-4 w"><img id="logo" src="{{asset('assets/images/logo.png')}}" alt="Logo">
    </div>
<div class="col-sm-8 w2">
    <h4><b>UNIVERSITY OF CALABAR CALABAR</b></h4>
    <p><b>Faculty &nbsp;:  &nbsp;</b> {{$f->faculty_name}}<br/>
    <b>Department&nbsp; : &nbsp;</b> {{$d->department_name}}<br/>
    <b>Course Of Study&nbsp;: &nbsp;</b>{{$fss->fos_name}}<br/>
{{!$yplus = $y + 1}}
  <b>Session :: </b>{{$y.' / '.$yplus}}</p>
  </div>
  </div>
  
 @yield('content')
 
 </div><!--//wrapper-->
    
 
    @include('partial._script')   

 </body>


</html>             