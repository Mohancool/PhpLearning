<?php
require 'connect.php';

// Get the posted data.



$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	

  // Validate.
  // if(trim($request->data->user_name) == '')
  // {
  //   return http_response_code(400);
  // }
	
  // Sanitize.
$first_name = mysqli_real_escape_string($con, trim($request->fname));
$last_name = mysqli_real_escape_string($con, trim($request->lname));
//$price = mysqli_real_escape_string($con, (int)$request->data->price);
$image = mysqli_real_escape_string($con, trim($request->image));
$user_email = mysqli_real_escape_string($con, trim($request->email_id));
$user_password = mysqli_real_escape_string($con, trim($request->password));
$user_mobile = mysqli_real_escape_string($con, trim($request->mobile));
$user_password = mysqli_real_escape_string($con, trim($request->password));
$user_latitude = mysqli_real_escape_string($con, trim($request->user_latitude));
$user_longitude =mysqli_real_escape_string($con, trim($request->user_longitude));
    
    

  // Store.
  $sql = "INSERT INTO `users`(`user_name`,`image`,`user_email`,`user_country`,`user_mobile`,`user_password`,`user_latitude`,`user_longitude`) VALUES ('{$user_name}','{$image}','{$user_email}','{$user_country}','{$user_mobile}','{$user_password}','{$user_latitude}','{$user_longitude}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $car = [
      'status' => true,
      'message' => 'Successfully Signup',
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$car]);
  }
  else
  {
    http_response_code(422);
  }
}