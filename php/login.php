<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["userName"];
    $password = $_POST["password"];

    // Use the email field for login
    $getExistingUserQuery = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $getExistingUser = $mysql_conn->query($getExistingUserQuery);

    $redis->set('loggedInUser',$email);
    
    if ($getExistingUser->num_rows == 0) {
        echo json_encode(['success' => false, 'data' => "User doesn't exist"]);
    } else {
        $userDetails = $getExistingUser->fetch_assoc();
        echo json_encode(['success' => true, 'data' => "Login Successful", 'user' => $userDetails]);
    }
}




