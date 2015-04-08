<?php
	include "xml.php";

	$name = @$_POST["name"]; 
	$msg = @$_POST["message"];
	$type = @$_POST["type"];
	$lastCounter = @$_POST["counter"]; 

	$fileManager =  new XMLManager();

	if ($type == "send")
	{
		$fileManager->insert($name, $msg);
	}
	else if ($type == "get")
	{
		echo $fileManager->getLastMessages($lastCounter);
	}
?>