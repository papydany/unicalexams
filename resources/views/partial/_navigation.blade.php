
<?php use Illuminate\Support\Facades\Auth; 
Const Agric = 18;
?>
        <!-- ******HEADER****** --> 
        <header class="header">  
          
            <div class="header-main container">
                <h1 class="logo col-md-2 col-sm-12">
                    <a href="{{url('/')}}"><img class="img-responsive" id="logo" src="assets/images/logo.png" alt="Logo" width="50px;"></a>
                </h1><!--//logo--> 
                <div class="info col-md-8 col-sm-12 text-center text-info">
                <h3><b>UNIVERSITY OF CALABAR RESULT PORTAL</b></h3>
                </div>          
                <div class="info col-md-2 col-sm-12">
                   
                    <div class="contact pull-right"><b>contact@unicalexams.edu.ng</b>
                    
                    </div><!--//contact-->
                </div><!--//info-->
            </div><!--//header-main-->
        </header><!--//header-->
        
        <!-- ******NAV****** -->
        <nav class="main-nav" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button><!--//nav-toggle-->
                </div><!--//navbar-header-->            
                <div class="navbar-collapse collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                      
  
                          @if (!Auth::guest())
                          @inject('r','App\RRR')
                        
  <?php 
    $result= $r->getstudenttype2(Auth::user()->id,Auth::user()->matric_number); 
    $duration =$r->getDuration(Auth::user()->fos_id);
    //$s=  session()->get('session_year');
    
    $studentReg =$r->getRegisteredStudent1(Auth::user()->id,'NORMAL');
    

  ?>

@if($result == 2)
  <li class="active nav-item"><a href="{{url('/')}}">Home</a></li>
                           <li class="nav-item"><a href="{{url('/profile')}}">Profile</a></li>
                       @if(session()->get('student_status') == 1)    
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Register Courses (New Students) <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{url('/register_course')}}">Register Courses</a></li>
                                @if(Auth::user()->programme_id == 2)
                                <li><a href="{{url('register_resit_course')}}">Register Resit Courses</a></li>

                                @endif
                               

                                <li><a href="{{url('/print_course')}}">Print Registered Courses</a></li>
                                <li><a href="{{url('/addCourses')}}">Add Courses</a></li>
                                <li><a href="{{url('/deleteCourses')}}">Delete Courses</a></li>        
                            </ul>
                        </li>
                        @elseif(session()->get('student_status') == 2)

                         

                            <li class="nav-item dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Register Courses (Returning Students) <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                               <!--<li><a href="{{url('returning_register_course')}}">Register Courses</a></li>-->
                                <li><a href="#">Register Courses</a></li>
                                 @if(Auth::user()->programme_id == 2)
                                <li><a href="{{url('register_resit_course')}}">Register Resit Courses</a></li>

                                @endif
                                 <!-- faculty of agric menu-->
                                 @if(Auth::user()->faculty_id == 18)
                                <li><a href="{{url('register_summer_course')}}">Register Summer Courses</a></li>
                                <li><a href="{{url('register_delayed_course')}}">Register Delayed Courses</a></li>
                                @endif
                               
                                  @if($studentReg !=null)
                                  
                                @if($studentReg->level_id >= $duration->duration)
                                <li><a href="{{url('register_long_vacation',[$studentReg->level_id,$duration->duration,$studentReg->session])}}">Register Long Vacation</a></li>
                               @endif
                               @endif
                                <li><a href="{{url('print_course')}}">Print Registered Courses</a></li>
                                <li><a href="{{url('addCourses')}}">Add Courses</a></li>
                                <li><a href="{{url('deleteCourses')}}">Delete Courses</a></li>        
                            </ul>
                        </li>
                        @endif
                        <li class="nav-item"><a href="{{url('view_result')}}">View Result</a></li>
                        @elseif($result == 1)
                           <li class="active nav-item"><a href="{{url('/home')}}">Home</a></li>
 <li class="nav-item"><a href="{{url('/pds')}}">Profile</a></li>
                     

                            <li class="nav-item"><a href="{{url('pds_view_result')}}" target="_blank">View Result</a></li>
                    @elseif($result == 0)
                    <h2>Some thing went wrong !!! contact system admin </h2>

                        @endif
                            <li class="nav-item">
                 <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                        @else

                       <li class="active nav-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="nav-item"><a href="{{url('faq')}}">FAQ</a></li>
                       <li class="nav-item"><a href="{{url('contact')}}">Contact</a></li>
                             
     <li class="nav-item"><a href="{{url('/login')}}">Login</a></li>
    <!-- <li class="nav-item"><a href="{{url('recovery_pin')}}">Recovery Pin</a></li>-->
     @endif
                                  
                    </ul><!--//nav-->
                </div><!--//navabr-collapse-->
            </div><!--//container-->
        </nav><!--//main-nav-->