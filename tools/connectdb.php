<?php
require_once('settings.php');   

// connect to the database server
$dbcon = mysql_connect(DBServer, DBUser, DBPassword);
if(!$dbcon) {
    die("Can't connect to database $server");
}
// select the database
mysql_select_db(DBName, $dbcon);
?>
