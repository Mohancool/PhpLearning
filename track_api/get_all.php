<?php
/**
 * Returns the list of cars.
 */
require 'connect.php';
    
$cars = [];
$sql = "SELECT * FROM wp_posts";

 

 
if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $cars[$cr]['id']    = $row['ID'];
    $cars[$cr]['post_author'] = $row['post_author'];
    $cars[$cr]['post_date'] = $row['post_date'];
    //$cars[$cr]['image'] = URL.'images/'.$row['image'];
    $cars[$cr]['post_content'] = $row['post_content'];
   
     $cars[$cr]['post_title'] = $row['post_title'];
     $cars[$cr]['post_status'] = $row['post_status'];
     $cars[$cr]['post_name'] = $row['post_name'];
    // $cars[$cr]['user_longitude'] = $row['user_longitude'];
    // $cars[$cr]['createdon'] = $row['createdon'];
    // $cars[$cr]['updateon'] = $row['updateon'];
    $cr++;
  }
    
  echo json_encode(['data'=>$cars]);
}
else
{
  http_response_code(404);
}

?>
