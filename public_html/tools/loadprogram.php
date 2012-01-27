<?php
include_once("helperfuncs.php");
require_once("connectdb.php");

$id = getUsrParam("id", 0);

if (!$id){
    header("Location: programlist.php");
    exit();
}
$query = "SELECT * FROM programs WHERE id=$id";
$result = mysql_query($query, $dbcon);

if(!$result) die("Invalid id: $id");

$program = mysql_fetch_assoc($result);
?>