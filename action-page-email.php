<?php

require_once "Mail.php";

$servername = "{ENDPOINT-TO-MYSQL-DATABASE}";
$username = "{USERNAME-FOR-DATABASE}";
$password = "{PASSWORD-FOR-DATABASE}";
$dbname = "{DATABASE-NAME}";

$vemail = $_POST['email'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql = "INSERT INTO subs (email)
VALUES ('{$vemail}')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";

      // Send verification email
      $verificationCode = md5($vemail);
      $verificationLink = "https://computersciencex.com/verify.php?code=$verificationCode";
      $subject = "Verify Your Email Address";
      $message = "Click the link below to verify your email address:\n$verificationLink";


} else {
  echo "Error: " . $sql . "" . $conn->error;
}

$from = "admin@computersciencex.com";
$to = $vemail;

$host = "ssl://smtp.zoho.eu";
$port = "465";
$username = 'admin@computersciencex.com';
$password = '{PASSWORD}';

$body = $message;

$headers = array ('From' => $from, 'To' => $to,'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'port' => $port,
    'auth' => true,
    'username' => $username,
    'password' => $password));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
  echo($mail->getMessage());
} else {
  echo("Message successfully sent!\n");
}

header("Location: https://computersciencex.com/indexSuccess.html", true, 301);  

$conn->close();

?>
