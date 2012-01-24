<?php

$server = "localhost";
$database = "webdb";
$user = "user";
$password = "password";

function getConnection() {
    global $server;
    global $user;
    global $password;
    global $database;
    
    $connection = mysql_connect($server, $user, $password);
    if(!$connection) {
        die("Can't connect to database $server");
    }
    
    mysql_select_db($database, $connection);
    
    return $connection;
}

?>