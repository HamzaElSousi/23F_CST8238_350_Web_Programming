<?php

/*
 Sets up the PDO database connection
*/

  //For EasyPHP Local Webserver 
  $host= 'localhost';
  $user = 'bookrep'; 
  $password = 'book@rep20';
  $dbname= 'assignment3crm';

  //You need to modify dbname and username($user) for SiteGround Web Server  
	 
  // $pdo = new PDO($host,$dbname,$user,$password);
  $connection = mysqli_connect($host, $user, $password, $dbname);
  // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	   

  // Check connection
  if (!$connection) {
      die("Connection failed: " . mysqli_connect_error());
  }
  ?>
