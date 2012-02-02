<?php
// test the connection to the database
include('../tools/settings.php');
include('../tools/helperfuncs.php');
  
$dbcon = mysql_connect(DBServer, DBUser, DBPassword);
if(!$dbcon) {
    die(getJsonObject(array('succes' => false, 'error' => 'connect')));
}
if(!mysql_select_db(DBName, $dbcon)) {
    die(getJsonObject(array('succes' => false, 'error' => 'database')));
}

echo getJsonObject(array('succes' => true));

?>