<?php

$server = "localhost";
$database = "webdb1237";
$user = "webdb1237";
$password = "me7habac";
    
$dbcon = mysql_connect($server, $user, $password);
if(!$dbcon) {
    die("Can't connect to database $server");
}
    
mysql_select_db($database, $dbcon);

?>
