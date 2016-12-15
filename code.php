<?php
	header("Access-Control-Allow-Origin: *");
	header('Content-Type:application/json; charset=UTF-8');
	include "xml.php";

	$name = @$_POST["name"];
	$msg = @$_POST["message"];
	$type = @$_POST["type"];
	$lastCounter = @$_POST["counter"];

	$fileManager =  new XMLManager();

	if ($type == "send")
	{
		$fileManager->insert($name, $msg);
		echo json_encode(array("status" => "success"));
	}
	else if ($type == "get")
	{
		echo $fileManager->getLastMessages($lastCounter);
	}
?>
