<?php
require_once('settings.php');   
$dbcon = mysql_connect(DBServer, DBUser, DBPassword);
if(!$dbcon) {
    die("Can't connect to database $server");
}
    
mysql_select_db(DBName, $dbcon);
?>
