<?php
require 'connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
 // Validate.
  if ((int)$request->Id < 1 || trim($request->Id) == '') {
    return http_response_code(400);
  }
    
  // Sanitize.
  $id = mysqli_real_escape_string($con, (int)$request->id);
  $user_latitude = mysqli_real_escape_string($con, trim($request->user_latitude));
  $user_longitude = mysqli_real_escape_string($con, trim($request->user_longitude));
  // Update.
  $sql = "UPDATE `users` SET `user_latitude`='$user_latitude',`user_longitude`='$user_longitude', `updateon`= NOW() WHERE `id` = '{$id}' LIMIT 1";

  if(mysqli_query($con, $sql))
  {
    http_response_code(204);
    $car = [
      'status' => true,
      'message' => 'Successfully Update',
     
    ];
    echo json_encode($car);
  }
  else
  {
    return http_response_code(422);
  }  
 }

?>