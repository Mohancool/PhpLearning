<?php

//Api.php

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
		$this->connect = new PDO("mysql:host=localhost;dbname=", "root", "");
	}

	function fetch_all()
	{
		$query = "SELECT * FROM user ORDER BY id";
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
		
		if(isset($_POST['u_name']))
		{
			// $form_data = array(
			// 	':u_name'		=>	mysql_real_escape_string( $_POST["u_name"]),
			// 	':u_email'		=>	mysql_real_escape_string( $_POST["u_email"]),
			// 	':u_mobile'		=>	mysql_real_escape_string( $_POST["u_mobile"]),
			// 	':u_country'   =>	mysql_real_escape_string( $_POST["u_country"]),
			// 	':u_password'   =>	mysql_real_escape_string( $_POST["u_password"])



				$form_data = array(
				':u_name'		=>	$_POST["u_name"],
				':u_email'		=>	$_POST["u_email"],
				':u_mobile'		=>	$_POST["u_mobile"],
				':u_country'   =>	$_POST["u_country"],
				':u_password'   =>	$_POST["u_password"]
				//':u_password' =>	password_hash($_POST["u_password"], PASSWORD_BCRYPT)
			);

         //   $user_password = password_hash($_POST["u_password"], PASSWORD_BCRYPT, array('cost' => 10));

			$query = "
			INSERT INTO user 
			(u_name, u_email,u_mobile,u_country, u_password) VALUES 
			(:u_name, :u_email, :u_mobile, :u_country ,:u_password)
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

      

     




	function login($u_email,$u_password)
	{
       
		$query = "SELECT * FROM user WHERE u_email='".$u_email."' AND u_password= '".$u_password."'";
       

		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			
			foreach($statement->fetchAll() as $row)
			{
				//if(password_verify($u_password,$row['u_password'])) 


				$data['status'] = true;
				$data['message'] = 'successfully login';
				$data['id'] = $row['id'];
				$data['Name'] = $row['u_name'];
				$data['Email'] = $row['u_email'];
				$data['Mobile'] = $row['u_mobile'];
				$data['Country'] = $row['u_country'];


                
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
		if(isset($_POST["u_name"]))
		{
			$form_data = array(
				':u_name'		=>	mysql_real_escape_string( $_POST["u_name"]),
				':u_email'		=>	mysql_real_escape_string( $_POST["u_email"]),
				':u_mobile'		=>	mysql_real_escape_string( $_POST["u_mobile"]),
				':u_country'   =>	mysql_real_escape_string( $_POST["u_country"]),
				//':u_password' =>	password_hash($_POST["u_password"], PASSWORD_BCRYPT, array('cost' => 10)),
				':u_password' =>	mysql_real_escape_string($_POST["u_password"]),
				':id'	=>	   $_POST['id']
			);
			$query = "
			UPDATE user 
			SET u_name = :u_name, u_email = :u_email, u_mobile= :u_mobile, u_country= :u_country, u_password= :u_password 
			WHERE id = :id
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
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
		}
		else
		{
			$data[] = array(
				'status'	=>	false
			);
		}
		return $data;
	}
	function delete($id)
	{
		$query = "DELETE FROM user WHERE id = '".$id."'";
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

function push_notification_android($device_id,$message){

    //API URL of FCM
    $url = 'https://fcm.googleapis.com/fcm/send';

    /*api_key available in:
    Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/    
    $api_key = 'AAAAKZLje1I:APbGQDw8FD...TjmtuINVB-g';
                
    $fields = array (
        'registration_ids' => array (
                $device_id
        ),
        'data' => array (
                "message" => $message
        )
    );

    //header includes Content type and api key
    $headers = array(
        'Content-Type:application/json',
        'Authorization:key='.$api_key
    );
                
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}



}



?>