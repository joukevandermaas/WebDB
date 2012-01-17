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

function createTable($name, $columns) {
    $query = "CREATE TABLE IF NOT EXISTS $name ( \n";
    
    foreach ($columns as $cname => $type) {
        $query .= "$cname $type";
        if ($cname == "id")
            $query .= " NOT NULL AUTO_INCREMENT PRIMARY KEY";
            
        if ($type == "TIMESTAMP")
            $query .= " DEFAULT NOW()";
        
        $query .= ",\n";
    }
    $query = rtrim($query, "\n,");
    
    return $query."\n)";
}

$tables = array(
    "programs" => array(
        "id"            => "SMALLINT",
        "orgs_id"       => "TINYINT",
        "hprogramid"    => "VARCHAR(20)",
        "croho"         => "SMALLINT",
        "name"          => "VARCHAR(100)",
        "summary"       => "TEXT",
        "level"         => "ENUM('0', '1', '2', '3')",
        "hodexurl"      => "TEXT"
    ),
    "posts" => array(
        "id"            => "INT",
        "programs_id"   => "SMALLINT",
        "users_id"      => "INT",
        "content"       => "LONGTEXT",
        "timestamp"     => "TIMESTAMP",
        "score"         => "SMALLINT",
        "comment_count" => "SMALLINT"
    ),
    "comments" => array(
        "id"            => "INT",
        "posts_id"      => "INT",
        "users_id"      => "INT",
        "content"       => "VARCHAR(140)",
        "timestamp"     => "TIMESTAMP"
    ),
    "users" => array(
        "id"                => "INT",
        "loginname"         => "VARCHAR(20)",
        "loginservice"      => "TINYINT",
        "firstname"         => "VARCHAR(20)",
        "lastname"          => "VARCHAR(30)",
        "registertimestamp" => "TIMESTAMP"
    ),
    "orgs" => array(
        "id"            => "TINYINT",
        "name"          => "VARCHAR(100)",
        "horgid"        => "VARCHAR(20)"
    )
);

$con = getConnection();
echo $con;
foreach($tables as $name => $columns) {
    echo mysql_query(createTable($name, $columns), $con);
}

?>