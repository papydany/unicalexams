<!DOCTYPE html>

 <html lang="en"> 
<head>
  @include('partial._header')
</head> 

<body class="home-page">
    <div class="wrapper">
 @include('partial._old_nav')
 @include('partial._message')  
 @yield('content')
 
    
    <!-- ******FOOTER****** --> 
    <footer class="footer">
     @include('partial._footer')    
    </footer>
    </div>
    @include('partial._script')   

 </body>


</html>             