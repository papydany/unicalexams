<?php

namespace App;
use DB;
use App\PdsResult;
use App\Pin;
use Auth;

class RRR
{
public function getstudenttype($id){
        $user =Pin::where('matric_number',$id)->first();
        return $user->student_type;
   }
   public function pds_result($id,$c_id,$mat_no,$s,$sm)
   {
   	$result = PdsResult::where([['session', $s],['pdg_user',$id],['matric_number',$mat_no],['course',$c_id],['semester',$sm]])->first();

return $result;
   }

   //======================================================================================================
 public   function get_course_avg($s_id,$course_id,$session){
$query =PdsResult::where([['pdg_user',$s_id],['session',$session],['course',$course_id]])->get();
$sum = $query->sum('total');

$no = Count($query);
if($no == 0)
{
 $avg ='No Score';
}else{
$avg = $sum/$no;
}

return $avg;

 }

 public function get_course_grade_point($total)
 {

  switch($total) {
      case $total =='No Score':
               $return['grade']  = '';
               $return['point'] = '';
                 return $return;
                 break;
            case $total >= 70:
                $return['grade'] = 'A';
                $return['point'] = 5;
               return $return;
                break;
            case $total >= 60:
                $return['grade']  = 'B';
                 $return['point'] = 4;
                  return $return;
                break;
            case $total >= 50:
                 $return['grade']  = 'C';
                 $return['point'] = 3;
     return $return;
                break;
            case $total >= 45:
                 $return['grade']  = 'D';
                 $return['point'] = 2;
                  return $return;
                break;
            case $total >= 40:
                 $return['grade']  = 'E';
                 $return['point'] = 1;
                  return $return;
                break;
            case $total < 40:
                 $return['grade']  = 'F';
                $return['point'] = 0;
                 return $return;
                break;
            
        }
    
 }

  public function get_cp($total,$cu)
 {
$entry_year =Auth::user()->entry_year;
if($entry_year <= 2016)
{
switch($total) {
      case $total =='No Score':
               
               $return = '';
                 return $return;
                 break;
            case $total >= 70:
              $return = 5*$cu;
               return $return;
                break;
            case $total >= 60:
               
                 $return = 4*$cu;
                  return $return;
                break;
            case $total >= 50:
                 
                 $return = 3*$cu;
     return $return;
                break;
            case $total >= 45:
                
                 $return = 2*$cu;
                  return $return;
                break;
            case $total >= 40:
                 
                 $return = 1*$cu;
                  return $return;
                break;
            case $total < 40:
                 
                $return = 0*$cu;
                 return $return;
                break;
            
        }
}else
{
  switch($total) {
      case $total =='No Score':
               
               $return = '';
                 return $return;
                 break;
            case $total >= 70:
              $return = 4*$cu;
               return $return;
                break;
            case $total >= 60:
               
                 $return = 3*$cu;
                  return $return;
                break;
            case $total >= 50:
                 
                 $return = 2*$cu;
     return $return;
                break;
            case $total >= 45:
                
                 $return = 1*$cu;
                  return $return;
                break;
            
            case $total < 44:
                 
                $return = 0*$cu;
                 return $return;
                break;
            
        }
}
  
    
 }
 
    
  public function get_cp_2($grade,$cu)
 {

  switch($grade) {

  
            case $grade == 'A':
              $return = 5*$cu;
               return $return;
                break;
            case $grade == 'B':
               
                 $return = 4*$cu;
                  return $return;
                break;
            case $grade =='C':
                 
                 $return = 3*$cu;
     return $return;
                break;
            case $grade == 'D':
                
                 $return = 2*$cu;
                  return $return;
                break;
            case $grade == 'E':
                 
                 $return = 1*$cu;
                  return $return;
                break;
            case $grade == 'F':
                 
                $return = 0*$cu;
                 return $return;
                break;
            
        }
    
 }

 public function getOldResult($stdcourse_id,$std_id,$session)
 {
 $result =DB::connection('mysql1')->table('students_results')
 ->where([['stdcourse_id',$stdcourse_id],['std_mark_custom2',$session],['std_id',$std_id]])->first();
 return $result;
 }

}