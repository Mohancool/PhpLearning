<?php

//Api.php
header("Access-Control-Allow-Origin", "*");
header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");

class API
{   
	//private $con = mysqli_connect("localhost","root","jprmarket","");
	private $connect = '';
	private $msg= '';

	function __construct()
	{
		$this->database_connection();
	}

	function database_connection()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=trackmybuddy", "root", "");
		//define(URL, "http://192.168.1.11/");
	}

	function fetch_all()
	{
		$query = "SELECT * FROM users ";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	function insert()
	{
		 
		if(isset($_POST['user_name']))
		{
			// $form_data = array(
			// 	':u_name'		=>	mysql_real_escape_string( $_POST["u_name"]),
			// 	':u_email'		=>	mysql_real_escape_string( $_POST["u_email"]),
			// 	':u_mobile'		=>	mysql_real_escape_string( $_POST["u_mobile"]),
			// 	':u_country'   =>	mysql_real_escape_string( $_POST["u_country"]),
			// 	':u_password'   =>	mysql_real_escape_string( $_POST["u_password"])



				$form_data = array(
				':user_name'	=>	mysql_real_escape_string($_POST["user_name"]),
			
              //  ':temp'   => mysql_real_escape_string($_FILES['image']['tmp_name']),
				':user_email'	=>	mysql_real_escape_string($_POST["user_email"]),
				':user_country'   =>	mysql_real_escape_string($_POST["user_country"]),
				':user_mobile'		=>	mysql_real_escape_string($_POST["user_mobile"]),
				':user_password'   =>	mysql_real_escape_string($_POST["user_password"]),
				':user_latitude'   =>	mysql_real_escape_string($_POST["user_latitude"]),
				':user_longitude'   =>	mysql_real_escape_string($_POST["user_longitude"])

				// move_uploaded_file(':image', "images/':image'" )
				//':u_password' =>	password_hash($_POST["u_password"], PASSWORD_BCRYPT)
			);

				if(!empty($_FILES['image']['name'])){



			$file_path = "images/";
			$image_file = time().basename($_FILES['image']['name']);
			$file_paths = $file_path.$image_file;
			move_uploaded_file($_FILES['image']['tmp_name'], $file_paths);
			
              }
         //   $user_password = password_hash($_POST["u_password"], PASSWORD_BCRYPT, array('cost' => 10));

			$query = "
			INSERT INTO users 
			(user_name, image , user_email ,user_country ,user_mobile ,user_password ,user_latitude ,user_longitude) VALUES 
			(:user_name, '$image_file', :user_email,  :user_country ,:user_mobile, :user_password, :user_latitude, :user_longitude)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				
				
				$data = array(
					'status'=>	true,
					'message' => 'Successfully Signup'
			        
				);
			}
			else
			{
				$data = array(
					'status'	=>	false,
					'message'   => 'Unsuccess Signup'
				);
			}
		}
		else
		{
			$data = array(
				'status'	=>	false,
				'message'   => 'Invalid Signup'

			);
		}
		return $data;
	}


      
function register()
	{
		 
		if(isset($_POST['fname']))
		{
			// $form_data = array(
			// 	':u_name'		=>	mysql_real_escape_string( $_POST["u_name"]),
			// 	':u_email'		=>	mysql_real_escape_string( $_POST["u_email"]),
			// 	':u_mobile'		=>	mysql_real_escape_string( $_POST["u_mobile"]),
			// 	':u_country'   =>	mysql_real_escape_string( $_POST["u_country"]),
			// 	':u_password'   =>	mysql_real_escape_string( $_POST["u_password"])



				$form_data = array(
				':fname'	=>	mysql_real_escape_string($_POST["fname"]),
			
              //  ':temp'   => mysql_real_escape_string($_FILES['image']['tmp_name']),
				':lname'	=>	mysql_real_escape_string($_POST["lname"]),
				':email_id'   =>	mysql_real_escape_string($_POST["email_id"]),
				
				':password'   =>	mysql_real_escape_string($_POST["password"]),
				':mobile'	=>	mysql_real_escape_string($_POST["mobile"])
				

				// move_uploaded_file(':image', "images/':image'" )
				//':u_password' =>	password_hash($_POST["u_password"], PASSWORD_BCRYPT)
			);

				if(!empty($_FILES['image']['name'])){


           // $base_url ="http://"
			$file_path = "images/";
			$image_file = time().basename($_FILES['image']['name']);
			$file_paths = $file_path.$image_file;
			move_uploaded_file($_FILES['image']['tmp_name'], $file_paths);
			
              }
         //   $user_password = password_hash($_POST["u_password"], PASSWORD_BCRYPT, array('cost' => 10));

			$query = "
			INSERT INTO user 
			(fname, lname , image , email_id , password , mobile,createdon) VALUES 
			(:fname, :lname , '$image_file' ,:email_id ,:password,:mobile, now())
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				
				
				$data = array(
					'status' =>	true,
					'message' => 'Successfully Signup'
			        
				);
			}
			else
			{
				$data = array(
					'status'	=>	false,
					'message'   => 'Unsuccess Signup'
				);
			}
		}
		else
		{
			$data = array(
				'status'	=>	false,
				'message'   => 'Invalid Signup'

			);
		}
		return $data;
	}

     




	function login($email_id,$password)
	{
       
		$query = "SELECT * FROM user WHERE email_id='".$email_id."' AND password= '".$password."'";
       

		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			
			foreach($statement->fetchAll() as $row)
			{
				//if(password_verify($u_password,$row['u_password'])) 


				$data['status'] = true;
				$data['message'] = 'Successfully login';
				$data['id'] = $row['id'];
				$data['Name'] = $row['fname'];
				

                
			}


			return $data;
		}
	
	}






	function fetch_single($id)
	{
		$query = "SELECT * FROM user WHERE id='".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{
				$data['u_name'] = $row['u_name'];
				$data['u_email'] = $row['u_email'];
				$data['u_password'] = $row['u_password'];
			}
			return $data;
		}
	}

	function update()
	{
		if(isset($_POST["id"]))
		{
			$form_data = array(
				':user_latitude'	=>	mysql_real_escape_string( $_POST["user_latitude"]),
				':user_longitude'   =>	mysql_real_escape_string( $_POST["user_longitude"]),
				
				':id'	=>	  mysql_real_escape_string( $_POST["id"])

			);
			$query = "
			UPDATE user 
			SET user_latitude = :user_latitude, user_longitude = :user_longitude, updateon = now()
			WHERE id = :id
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data) )
			{  
              
				

				$data = array(
					'status'	=>	true,
					'message'   =>  'Successfully Updated'
					 
				);
			}
			else
			{
				$data = array(
					'status'	=>	false
				);
			}
		}
		else
		{
			$data = array(
				'status'	=>	false
			);
		}
		return $data;
	}




	function delete($user_id)
	{
		$query = "DELETE FROM users WHERE user_id = '".$user_id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			$data[] = array(
				'status'	=>	true
			);
		}
		else
		{
			$data[] = array(
				'status'	=>	false
			);
		}
		return $data;
	}

	function fetch_users($user_platform)
	{

	if($user_platform == 'web' || $user_platform == 'Web' || $user_platform == 'WEB' || $user_platform == 'WEb' ){

		$query = "SELECT * FROM users where user_platform = '".$user_platform."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
		else
		{
			$data[] = array(
				'status'	=>	false
			);
		}
	}
	else
		{
			$data = array(
				'status'	=>	false,
			    'message'   => 'This service for only web users'
			);
		}
		return $data;
	}




	//  function upload(){ //  testing  Aigple
		

	// 	$json_response = [];
		
	//     if($user_id!=''){
			
	// 		if(!empty($_FILES['image']['name'])){
	// 		$file_path = "images/";
	// 		$image_file = time().basename($_FILES['image']['name']);
	// 		$file_paths = $file_path.$image_file;
	// 		move_uploaded_file($_FILES['image']['tmp_name'], $file_paths);
			
	// 		    $InsertData = $conn->query("INSERT INTO users SET image ='$image_file'");
				
	// 		    if($InsertData){
					
	// 				$base_url="http://".$_SERVER['SERVER_NAME'];
	// 				$array_post['image_url'] = $base_url.'/images/';
	// 			    $array_post['image']=$image_file;
				 
	// 			    array_push($json_response,$array_post);
					
	// 				$data['status']="1";
	// 			    $data['message']="Successfully";
	// 				$data['update details']=$json_response;
	// 			    echo json_encode($data);
					
	// 			}else{
					
	// 				$data['status']="0";
	// 			    $data['message']="Something Went Wrong.Please try Again !!";
	// 			    echo json_encode($data);
					
	// 			}
				
	// 		}else{
	// 			$data['status']="2";
	// 			$data['message']="Please select Image First.";
	// 			echo json_encode($data);
	// 		}
			
	// 	}else{
			 
	// 		$data['status']="3"; 
	// 	    $data['message']="Customer Id Is blank !!"; 
	// 	    echo json_encode($data);
			
	// 	 }
		
	// }
}

?>