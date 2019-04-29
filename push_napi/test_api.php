<?php

//test_api.php

include('Api.php');

$api_object = new API();

if($_GET["action"] == 'fetch_all')
{
	$data = $api_object->fetch_all();
}

if($_GET["action"] == 'register')
{
	$data = $api_object->insert();
}

if($_GET["action"] == 'login')
{
	$data = $api_object->login($_POST["u_email"],$_POST["u_password"]);
}

if($_GET["action"] == 'push_notify')
{
	$data = $api_object->push_notification_android($_POST["device_id"],$_POST["message"]);
}

if($_GET["action"] == 'fetch_single')
{
	$data = $api_object->fetch_single($_GET["id"]);
}

if($_GET["action"] == 'update')
{
	$data = $api_object->update();
}

if($_GET["action"] == 'delete')
{
	$data = $api_object->delete($_GET["id"]);
}

echo json_encode($data);

?>