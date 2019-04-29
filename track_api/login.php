<?php
require 'connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
  
  // Validate.
  if(trim($request->user_email) == '' && trim($request->user_password) == '')
  {
    return;
  }
    
  // Sanitize.
  $user_email = mysqli_real_escape_string($con, trim($request->user_email));
  $user_password = mysqli_real_escape_string($con, trim($request->user_password));

  // Get by id.
  $sql = "SELECT * FROM `users` WHERE `user_email` ='{$user_email}' AND `user_password` ='{$user_password}' LIMIT 1";

 if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $cars[$cr]['id']    = $row['id'];
    $cars[$cr]['user_name'] = $row['user_name'];
    $cars[$cr]['image'] = URL.'images/'.$row['image'];
    $cars[$cr]['user_email'] = $row['user_email'];
    $cars[$cr]['user_country'] = $row['user_country'];
    $cars[$cr]['user_mobile'] = $row['user_mobile'];
    $cars[$cr]['user_password'] = $row['user_password'];
    $cars[$cr]['user_latitude'] = $row['user_latitude'];
    $cars[$cr]['user_longitude'] = $row['user_longitude'];
    $cr++;
  }
    
  echo json_encode($cars);
}
else
{
  http_response_code(404);
}

exit;
}
?>