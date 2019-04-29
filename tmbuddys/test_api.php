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

if($_GET["action"] == 'reg')
{
	$data = $api_object->register();
}

if($_GET["action"] == 'login')
{
	$data = $api_object->login($_POST["email_id"],$_POST["password"]);
}


if($_GET["action"] == 'fetch_single')
{
	$data = $api_object->fetch_single($_GET["id"]);
}

if($_GET["action"] == 'fetch_users')
{
	$data = $api_object->fetch_users($_POST["user_platform"]);
}

if($_GET["action"] == 'addtrip')
{
	$data = $api_object->update();
}

if($_GET["action"] == 'upload')
{
	$data = $api_object->upload();
}


if($_GET["action"] == 'delete')
{
	$data = $api_object->delete($_GET["id"]);
}

echo json_encode($data);

?>