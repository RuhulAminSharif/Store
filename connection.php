<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "store";
    // Create connection
    $con = mysqli_connect($servername, $username, $password, $db_name);
    
    // Check connection
    if (mysqli_connect_errno()){
        echo "Failed to create connection with MySQL: ". mysqli_connect_error();
    }
?>