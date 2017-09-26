<?php

	$username = 'root';
	$password = NULL;
	$dbname = 'netology14';
	
	$todo = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $username, $password);