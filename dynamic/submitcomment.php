<?php
session_start();
require("../tools/connectdb.php");
include("../tools/helperfuncs.php");

$text = getUsrParam('text', '', $_POST);
$pid = getUsrParam('pid', 0, $_POST);

$ticket = getUsrParam("ticket", '', $_SESSION);
$service = getUsrParam("loginservice", 0, $_SESSION);
$userId = getUsrParam('user', 0, $_SESSION); 

if ($userId === 0)
    die(getJsonObject(array(
        'succes' => false,
        'loggedin' => false
    )));

$user = getUserInfo($userId);

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

$query = "UPDATE posts SET comment_count=comment_count+1 WHERE id=$pid";
mysql_query($query, $dbcon);

echo getJsonObject(array(
    'succes' => true,
    'user' => $user['firstname']." ".$user['lastname']
));
    
?>
