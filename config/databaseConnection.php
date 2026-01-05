<?php
    
    $username = 'root';
    $host = "localhost";
    $password = "";
    $dbname = "password_manager";
    $port = 3307;

    $conn = new mysqli($host,$username ,$password, $dbname, $port);
    if ($conn->connect_error) {
       echo "Something went wrong";
    }
    // echo "database is connected";

?>