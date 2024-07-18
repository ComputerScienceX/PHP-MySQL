<?php

$servername = "{ENDPOINT-TO-MYSQL-DATABASE}";
$username = "{USERNAME-FOR-DATABASE}";
$password = "{PASSWORD-FOR-DATABASE}";
$dbname = "{DATABASE-NAME}";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    
    // Update user status to verified
    $sql = "UPDATE subs SET verified = 1 WHERE MD5(email) = '$code'";

    
    if ($conn->query($sql) === TRUE) {
        header("Location: https://computersciencex.com/indexVerify.html", true, 301);  

    } else {
        echo "Error verifying email: " . $conn->error;
    }
}


$conn->close();

?>
