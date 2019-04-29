<?php
/**
 * Returns the list of cars.
 */
require 'connect.php';
    
$cars = [];
$sql = "SELECT id,fname,lname,image,email_id,mobile,password,user_latitude,user_longitude,createdon,updateon FROM user";

 


if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $cars[$cr]['id']    = $row['id'];
    $cars[$cr]['fname'] = $row['fname'];
    $cars[$cr]['lname'] = $row['lname'];
    $cars[$cr]['image'] = URL.'images/'.$row['image'];
    $cars[$cr]['email_id'] = $row['email_id'];
   
    $cars[$cr]['mobile'] = $row['mobile'];
    $cars[$cr]['password'] = $row['password'];
    $cars[$cr]['user_latitude'] = $row['user_latitude'];
    $cars[$cr]['user_longitude'] = $row['user_longitude'];
    $cars[$cr]['createdon'] = $row['createdon'];
    $cars[$cr]['updateon'] = $row['updateon'];
    $cr++;
  }
    
  echo json_encode(['data'=>$cars]);
}
else
{
  http_response_code(404);
}

?>
