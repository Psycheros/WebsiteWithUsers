<?php

//the database's hostname
$dbhost = 'localhost';
//the database's username
$dbuser = 'username';
//the database's password for that username
$dbpass = 'password';
//the database to be used
$dbname = 'database';

//connection that uses those values
$con = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

//if there were a problem report that
if ($con->connect_error){
	die("Connection failed: " . $con->connect_error);
}
 
?>
