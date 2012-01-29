<?php
session_start();
include '../tools/helperfuncs.php';
require '../tools/connectdb.php';

$text = getUsrParam('text', '', $_POST);
$title = getUsrParam('title', '', $_POST);
$p_id = getUsrParam('id', 0, $_POST);

$ticket = getUsrParam("ticket", '', $_SESSION);
$service = getUsrParam("loginservice", 0, $_SESSION);
$user = isLoggedIn($ticket, $service) 
    ? getUserInfo($ticket, $service) 
    : die(getJsonObject(array('succes' => false, 'loggedin' => false)));

if ($text === '' || $title === '') {
    die (getJsonObject(array(
        'succes' => false,
        'loggedin' => true,
        'error' => 'message'
    )));
}
if ($p_id === 0) {
    die(getJsonObject(array(
        'succes' => false,
        'loggedin' => true,
        'error' => 'pid'
    )));
}
    
$query = "INSERT INTO posts (program_id, user_id, title, content) ".
    "VALUES ($p_id, ".$user['id'].", '".$title."', '".$text."')";
$result = mysql_query($query, $dbcon);
if (!$result) {
    die(getJsonObject(array(
        'succes' => false,
        'loggedin' => true,
        'error' => 'database'
    )));
}

$postId = mysql_insert_id($dbcon);

echo getJsonObject(array(
    'succes' => true,
    'user' => $user['firstname'].' '.$user['lastname'],
    'id' => $postId
));


?>
