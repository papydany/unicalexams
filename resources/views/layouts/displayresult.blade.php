<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
 <html lang="en"> 
<head>
  @include('partial._header')
    <link rel="stylesheet" href="{{URL::to('assets/plugins/bootstrap/css/bootstrap.min.css')}}" media="all"> 
</head> 
<style type="text/css">
.table-bordered > tbody > tr > td{border: 1px solid #090909;}
.table-bordered > tbody > tr > th{border: 1px solid #090909;}
.table-bordered {border: 1px solid #090909;}
@media print {
.w{width: 10%;float: left;}
.w22{width: 50%;float: left;}
.w2{width: 50%;float: left;}
.w5{width: 40%;float: left;clear:all;}
.w3{width: 800px;float: left;}
.w4{width: 100%;float: left;}
.w22m{width: 100%;}
.table-bordered > tbody > tr > td{border: 2px solid #090909;}
.table-bordered > tbody > tr > th{border: 2px solid #090909;}
.table-bordered {border: 2px solid #090909;}
body {
font-size: 12px;
}
}
</style>
<body class="home-page">
   <div class="content container">
    <div class="row">
    <div class="col-xs-12" style="padding-top: 10px;padding-bottom:10px;">
    <div class="col-sm-2 w"><img id="logo" src="{{asset('assets/images/logo.png')}}" alt="Logo">
    </div>
<div class="col-sm-4 w2">
    <h4><b>UNIVERSITY OF CALABAR CALABAR</b></h4>
</div>
    <div class="col-sm-4 w5">
    <p><b>Faculty &nbsp;:  &nbsp;</b> {{$f->faculty_name}}<br/>
    <b>Department&nbsp; : &nbsp;</b> {{$d->department_name}}<br/>
    <b>Course Of Study&nbsp;: &nbsp;</b>{{$fss->fos_name}}<br/>
{{!$yplus = $y + 1}}
  <b>Session :: </b>{{$y.' / '.$yplus}}
<br/>
<b>Season :: </b>{{$season}}</p>
  </div>
  </div>
  
 @yield('content')
 
 </div><!--//wrapper-->
    
 
    @include('partial._script')   

 </body>


</html>             