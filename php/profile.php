<?php
require_once 'config.php';
use MongoDB\Driver\Query;
use MongoDB\Driver\Manager;
use MongoDB\Driver\BulkWrite;
use MongoDB\BSON\ObjectId;


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $email=$_GET["email"];

    //fetching email from Redis 
    $redisLoggedInUser= $redis->get('loggedInUser');

    $getExistingUserQuery = "SELECT * FROM user WHERE email='$email'";
    $getExistingUser = $mysql_conn->query($getExistingUserQuery);
    
    $userDetails = $getExistingUser->fetch_assoc();




    $filter = ['email' => $email];
    $query = new Query($filter);

    $result = $mongoManager->executeQuery("$mongoDatabase.$mongoCollection", $query);

    // echo $result->isDead();

    if(!$result->isDead()){
        foreach ($result as $document) {
            echo json_encode(['success' => true, 'data' => 'Data fetched successfully','sqlUser'=>$userDetails, 'mongoUser' => $document]);
            break;
            return;
            // return;
        }
    }else{
        echo json_encode(['success' => true, 'data' => "Login Successful", 'sqlUser' => $userDetails]);
        return;
    }

    // echo json_encode(['success' => true, 'data' => "Login Successful", 'sqlUser' => $userDetails]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $bulk = new BulkWrite;
    // echo ($_POST['state']);

    $params = [
        'fullName' => $_POST['fullName'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'age' => $_POST['age'],
        'dob' => $_POST['dob'],
        'city' => $_POST['city'],
        'Street' => $_POST['street'],
        'sTate' => $_POST['state'],
        'zIp' => $_POST['zip'],
    ];

    $filter = ['email' => $_POST['email']];
    $existingUser = $bulk->update(
        $filter,
        ['$set' => $params],
        ['upsert' => true]
    );

    $mongoManager->executeBulkWrite("$mongoDatabase.$mongoCollection", $bulk);

    $query = new Query($filter);
    $result = $mongoManager->executeQuery("$mongoDatabase.$mongoCollection", $query);

    foreach ($result as $document) {
        echo json_encode(['success' => true, 'data' => 'Data inserted/updated successfully', 'user' => $document]);
        return;
    }

    echo json_encode(['success' => false, 'data' => 'Error fetching user data']);


   
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

    $redis->del('loggedInUser');
    echo json_encode(['success' => true, 'message' => 'Logged out Successfully']);
}
?>
