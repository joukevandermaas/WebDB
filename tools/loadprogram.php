<?php
include_once("helperfuncs.php");
require_once("connectdb.php");

// load the program from the database (very simple)

// getUsrParam uses $_GET, but makes it safe
$id = getUsrParam("id", 0);

if (!$id){
    header("Location: programlist.php");
    exit();
}
$query = "SELECT programs.*, orgs.name as org_name FROM ".
    "programs JOIN orgs on programs.org_id=orgs.id ".
    "WHERE programs.id=$id";
$result = mysql_query($query, $dbcon);

if(!$result) die("Invalid: ".mysql_error());

$program = mysql_fetch_assoc($result);
?>
