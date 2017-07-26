<?php
session_start();
define('SITEURL','https://yoursiteurl.com/user/'); 
define('APIURL','https://yoursiteurl.com/api/'); 
define('TOKEN', 'YOUR_TOKEN');
$servername = "dbhost";
$username = "database-user";
$password = "database_password";
$dbname = "database_name";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
require 'functions.php';
?>