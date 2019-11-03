<?php
	try
	{
		$db = new PDO ('mysql:host=localhost;dbname=plans_data','root','mysql',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	}
	catch (PDOException $e)
	{
		echo 'Error connecting to DB!';
	    exit;
	}
?>