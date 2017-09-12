

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
                  
                      
                   
                         
                    <div class="contact pull-right text-danger">
                    complain@unicalexams.edu.ng
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
                       
  <li class="nav-item"><a href="{{url('/')}}">Hope</a></li>

                          @if (!Auth::guest())
                           <li class="nav-item"><a href="{{url('/pds')}}">Profile</a></li>
                     

                            <li class="nav-item"><a href="{{url('view_result')}}">View Result</a></li>
                        @endif
                     
                        <li class="nav-item"><a href="events.html">Events</a></li>
                       <li class="nav-item"><a href="{{url('faq')}}">FAQ</a></li>
                       
                        <li class="nav-item"><a href="contact.html">Contact</a></li>
@if (!Auth::guest())
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
     <li class="nav-item"><a href="{{url('/login')}}">Login</a></li>
                                    @endif

                    </ul><!--//nav-->
                </div><!--//navabr-collapse-->
            </div><!--//container-->
        </nav><!--//main-nav-->