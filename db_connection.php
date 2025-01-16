<?php 

function db_connection() {
    $creds = [
        "Username" => $_ENV["DB_USERNAME"],
        "Password" => $_ENV["DB_PASSWORD"],
        "Database" => $_ENV["DB_DATABASE"],
        "Host" => $_ENV["DB_HOST"]
    ];
    
    $conn = new mysqli($creds["Host"], $creds["Username"], $creds["Password"], $creds["Database"]);
    
    if($conn->connect_error){
        throw new Exception('Database connection error', 500);
    }

    return $conn;
}


?>