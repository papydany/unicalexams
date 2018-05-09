 <!-- Javascript -->          
    <script type="text/javascript" src="{{URL::to('assets/plugins/jquery-1.12.3.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script> 
   <script type="text/javascript" src="{{URL::to('assets/plugins/bootstrap-hover-dropdown.min.js')}}"></script> 
    <script type="text/javascript" src="{{URL::to('assets/plugins/back-to-top.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/plugins/jquery-placeholder/jquery.placeholder.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/plugins/pretty-photo/js/jquery.prettyPhoto.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/plugins/flexslider/jquery.flexslider-min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/plugins/jflickrfeed/jflickrfeed.min.js')}}"></script> 
    <script type="text/javascript" src="{{URL::to('assets/js/main.js')}}"></script>  
     <script src="{{URL::to('parsley.min.js')}}"></script>
        <script src="{{URL::to('js/webticker.js')}}"></script>
     <script>
    $(document).ready(function(){
  $('#webTicker').webTicker();  
$("#faculty").change( function() {
 
  $("#myModal").modal();  
var id =$(this).val();

   $.getJSON("/getdepartment/"+id, function(data, status){

    var $department = $("#department");
    $department.empty();
    $department.append('<option value="">Select Department</option>');
   $.each(data, function(index, value) {

   $department.append('<option value="' +value.id +'">' + value.department_name + '</option>');
  });
  $("#myModal").modal("hide");
    });


});



$("#state").change( function() {
 
  $("#myModal").modal();  
var id =$(this).val();

   $.getJSON("/getlga/"+id, function(data, status){
    var $lga = $("#lga");
    $lga.empty();
    $lga.append('<option value="">Select LGA</option>');
   $.each(data, function(index, value) {
   $lga.append('<option value="' +value.id +'">' + value.lga_name + '</option>');
  });
  $("#myModal").modal("hide");
    });


});

$("#department").change( function() {
 

var id =$(this).val();
var p_id = document.getElementById("programme").value;
if(p_id == '')
{
  alert('you have not select your programme');

  return;
}
  $("#myModal").modal();  
   $.getJSON("/getfos/"+id+"/"+p_id, function(data, status){
    var $fos = $("#fos");
    $fos.empty();
    $fos.append('<option value="">Select FOS</option>');
   $.each(data, function(index, value) {

   $fos.append('<option value="' +value.id +'">' + value.fos_name + '</option>');
  });
  $("#myModal").modal("hide");
    });


});

$("#programme").change( function() {
 

var id =$(this).val();
 $("#myModal").modal();  

  
    var $entry_month = $("#entry_month");
    $entry_month.empty();
if(id == 4)
{
$entry_month.append('<option value="">Select entry month</option>');
      $entry_month.append('<option value="1">April Contact </option>');
 $entry_month.append('<option value="2"> August Contact</option>');
 

}
else{
   $entry_month.append('<option value="0"> january</option>');
}
 $("#myModal").modal("hide");
});
// course registration page
        $('#register').click(function()
        {
           if($('input[name="id[]"]:checked').length < 1)
           {

               alert('you have not  select any course.');
               return false;
           }
           var min = $('#minimum').val();
            var max = $('#maximum').val();
           var sum = 0;
            $('input[name="id[]"]:checked').each(function() {


                sum += Number($(this).val());
            });
            if(sum < min)
            {
                alert('Your course unit is less than '+ min + ' units.Minimun course unit is '+ min);
                return false;
            }
            else if(sum > max)
            {
                alert('Your course unit is more than '+ max +' units. Maximun units is '+ max);
                return false
            }


        });


$("#fac").change( function() {
 
  $("#myModal").modal();  
var id =$(this).val();

   $.getJSON("/getdept/"+id, function(data, status){

    var $department = $("#dept");
    $department.empty();
    $department.append('<option value="">Select Department</option>');
   $.each(data, function(index, value) {
 
   $department.append('<option value="' +value.id +'">' + value.department_name + '</option>');
  });
  $("#myModal").modal("hide");
    });


}); 



$("#dept").change( function() {
 

var id =$(this).val();
var p_id = document.getElementById("programme").value;

  $("#myModal").modal();  
   $.getJSON("/gfos/"+id+"/"+p_id, function(data, status){
    var $fos = $("#fos");
    $fos.empty();
    $fos.append('<option value="">Select FOS</option>');
   $.each(data, function(index, value) {

   $fos.append('<option value="' +value.id +'">' + value.fos_name + '</option>');
  });
  $("#myModal").modal("hide");
    });


});       

});
    </script>
