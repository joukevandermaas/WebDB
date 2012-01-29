<?php
session_start();
require("../tools/connectdb.php");
include("../tools/helperfuncs.php");

$text = getUsrParam('text', '', $_POST);
$pid = getUsrParam('pid', 0, $_POST);

$ticket = getUsrParam("ticket", '', $_SESSION);
$service = getUsrParam("loginservice", 0, $_SESSION);
$user = isLoggedIn($ticket, $service) 
    ? getUserInfo($ticket, $service) 
    : die(getJsonObject(array('succes' => false, 'loggedin' => false)));

if ($text === '') 
    die(getJsonObject(array(
        'succes' => false, 
        'loggedin' => true, 
        'error' => 'message'
    )));

$query = "INSERT INTO comments (post_id, user_id, content) VALUES ".
    "($pid, ".$user['id'].", '$text')";

$result = mysql_query($query, $dbcon);
if (!$result) 
    die(getJsonObject(array(
        'succes' => false, 
        'loggedin' => true, 
        'error' => 'database'
    )));

echo getJsonObject(array(
    'succes' => true,
    'user' => $user['firstname']." ".$user['lastname']
));
    
?>