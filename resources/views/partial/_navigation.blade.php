

        <!-- ******HEADER****** --> 
        <header class="header">  
          
            <div class="header-main container">
                <h1 class="logo col-md-2 col-sm-2">
                    <a href="url('/')"><img id="logo" src="assets/images/logo.png" alt="Logo"></a>
                </h1><!--//logo--> 
                <div class="info col-md-8 col-sm-10 text-center text-info">
                <h3>UNIVERSITY OF CALABAR RESULT PORTAL</h3>
                </div>          
                <div class="info col-md-2 col-sm-12">
                   
                    <div class="contact pull-right">
                    contact@unicalexams.edu.ng
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
    $result= $r->getstudenttype(Auth::user()->matric_number); 

  ?>

@if($result == 2)
  <li class="active nav-item"><a href="{{url('/')}}">Home</a></li>
                           <li class="nav-item"><a href="{{url('/profile')}}">Profile</a></li>
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Courses <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{url('/register_course')}}">Register Courses</a></li>
                                <li><a href="{{url('/print_course')}}">Print Registered Courses</a></li>

                                        
                            </ul>
                        </li>

                           <li class="nav-item dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Result <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{url('view_result')}}">View Result</a></li>
                                
                                      
                            </ul>
                        </li>
                     
                        @elseif($result == 1)
                           <li class="active nav-item"><a href="{{url('/home')}}">Home</a></li>
 <li class="nav-item"><a href="{{url('/pds')}}">Profile</a></li>
                     

                            <li class="nav-item"><a href="{{url('pds_view_result')}}" target="_blank">View Result</a></li>


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
     @endif
                                  
                    </ul><!--//nav-->
                </div><!--//navabr-collapse-->
            </div><!--//container-->
        </nav><!--//main-nav-->