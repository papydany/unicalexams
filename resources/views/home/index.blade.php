@extends('layouts.main')
@section('title','Home')
@section('content')

 <div class="content container">


<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5c2e59dd7a79fc1bddf32c5b/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<div class="row" style="padding: 20px;margin-bottom: 20px;">
  <div class="col-sm-12" style="height: 50px !important;">
 <ul id="webTicker">
    <li><a data-toggle="modal" data-target="#myModal"><h3>How Does  Direct Entry (D/E) Student Register for Courses?</h3></a></li>
     <li class="text-danger"><h3>You can now chat with us live, by clicking the chat button at the buttom site of your home page. Thank you</h3></li>
   
</ul>
  </div>
</div>
    

        <div class="row" style=" margin-bottom: 50px;">
  
        <div class="col-sm-4 col-md-4 thumbnail">
        <h2 class='text-primary text-center'><u>New Student</u></h2>
        <h3 class="text-danger text-center"> UME / CES / DE / DIPLOMA</h3>
      
        <p>
        <a href="{{url('newRegLogin')}}" class="btn btn-info btn-block">Create Profile  for 2020/2021 && 2021/2022  </a>
        </p>
        <p>
        <a href="{{url('/login')}}" class="btn btn-info btn-block">Register Courses</a>
        </p>
        <p>
        <a href="{{url('/login')}}" class="btn btn-info btn-block">Check Result</a>
        </p>

        </div>


         <div class="col-sm-4 col-md-4  thumbnail">
         <h2 class='text-primary text-center'><u>Returning Students </u></h2>
         <h3 class="text-danger text-center"> UME / CES / DE / DIPLOMA</h3>
         <p>
        <a href="{{url('/enter_pin1')}}" class="btn btn-info btn-block">Create Profile(if you have not)</a>
        </p>

        <p>
     <a href="{{url('/oldlogin')}}" class="btn btn-info btn-block">Check Result</a>     
       </p>
       <p>
     <a href="{{url('oldlogin')}}" class="btn btn-info btn-block">Register Courses</a>     
       </p>
        </div>
 <div class="col-sm-4 col-md-4  thumbnail">
 <h2 class='text-primary text-center'><u>Entry Year 2015/2016 & below</u></h2>
<h3 class="text-danger text-center"> UME / CES / DE / DIPLOMA</h3>
<p>
<a href="{{url('/oldreturnstudent')}}" class="btn btn-info btn-block">Check Result (2015/2016 & Below)</a>
</p>
<p>
<a href="#" class="btn btn-info btn-block"></a>
</p>
<p>
<a href="#" class="btn btn-info btn-block"></a>
</p>
        </div>


        </div>
        
           
        
        </div><!--//content-->

   <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">How Does Direct Entry (D/E) Student Register for Courses?</h4>
      </div>
      <div class="modal-body">
        <p class="text-danger"> All direct entry students are expected to spend 3 years for a four years programme and 4 years for a 5 years programme in the University of Calabar. Hence, their registration does not start at 2/4. Rather, their course registration starts at 100 levels, 200 levels and 300 levels for the direct entry of 4 years programme, and 100 level, 200 levels, 300 levels and 400 levels for the direct entry of 5 years programme. The First year of the Direct Entry student for courses registration is not 200 levels, rather 100 levels. Meaning that all D/E students while registering should select 100 level under direct entry course registration and also while checking result, select 100 level under direct entry platform. Please Direct Entry students, take note.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection