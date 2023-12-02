<?php
// MySQL Instance
$mysql_conn = new mysqli("localhost", "root", "", "guvi");

if ($mysql_conn->connect_error) {
    die("MySQL Connection failed: " . $mysql_conn->connect_error);
}


// Mongo Instance
$mongoManager = new MongoDB\Driver\Manager("mongodb://rishabh:rishabh@ac-jzelyqr-shard-00-00.dcqvyle.mongodb.net:27017,ac-jzelyqr-shard-00-01.dcqvyle.mongodb.net:27017,ac-jzelyqr-shard-00-02.dcqvyle.mongodb.net:27017/Cluster0?ssl=true&replicaSet=atlas-od5ub7-shard-0&authSource=admin&retryWrites=true&w=majority ");
$mongoDatabase = "guvi";
$mongoCollection = "user";

// Redis Instance
$redis=new Redis();
$redis->connect('localhost',6379);
$redis->auth('password');
