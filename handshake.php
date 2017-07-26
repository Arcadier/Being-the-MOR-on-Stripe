<?php
include('config.php');
$logs=file_get_contents('php://input');
$sql = "INSERT INTO payment_logs (logs,payment_type,payment_status,ipaddress) VALUES ('".$logs."','stripe','pending','". $_SERVER['REMOTE_ADDR']."')";

if ($conn->query($sql) === TRUE) {
  echo  $last_id = $conn->insert_id;
  exit;
} else {
    $error="Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
exit;
//file_put_contents("post.log",print_r($_POST,true));
//file_put_contents('test.txt', file_get_contents('php://input'));
?>