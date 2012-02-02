<?php
session_start();
require("../tools/connectdb.php");
include("../tools/helperfuncs.php");

// getUsrParam (in helperfuncs.php) escapes the strings
$text = getUsrParam('text', '', $_POST);
$pid = getUsrParam('pid', 0, $_POST);

$ticket = getUsrParam("ticket", '', $_SESSION);
$service = getUsrParam("loginservice", 0, $_SESSION);
$userId = getUsrParam('user', 0, $_SESSION); 

// check if the user is logged in
if ($userId === 0)
    die(getJsonObject(array(
        'succes' => false,
        'loggedin' => false
    )));

$user = getUserInfo($userId);

// check if the user entered a message at all
if ($text === '') 
    die(getJsonObject(array(
        'succes' => false, 
        'loggedin' => true, 
        'error' => 'message'
    )));

$query = "INSERT INTO comments (post_id, user_id, content) VALUES ".
    "($pid, ".$userId.", '$text')";

$result = mysql_query($query, $dbcon);
if (!$result) 
    die(getJsonObject(array(
        'succes' => false, 
        'loggedin' => true, 
        'error' => 'database'
    )));

// Since this is the only file that adds comments,
// we can add a column comment_count on the table posts to make
// things easier within select statements and keep it up to date here
$query = "UPDATE posts SET comment_count=comment_count+1 WHERE id=$pid";
mysql_query($query, $dbcon);

echo getJsonObject(array(
    'succes' => true,
    'user' => $user['firstname']." ".$user['lastname']
));
    
?>
