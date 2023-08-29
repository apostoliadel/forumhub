<?php

try {
    // Database connection parameters
    $host = "localhost";    
    $dbname = "forum";      
    $user = "root";         
    $pass = "";             
    
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); // Create a PDO connection
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error handling attributes


    // if($conn == true){
    //     echo "DB Connection successful";
    // } else {
    //     echo "error";
    // }

} catch(PDOException $Exception) {
    echo $Exception->getMessage(); // error message if connection fails
}