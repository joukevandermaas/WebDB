<?php
session_start();
include '../tools/helperfuncs.php';
require '../tools/connectdb.php';

$pid = getUsrParam("pid", 0);
$up = getUsrParam("value", 0);

// you only have 1 vote
$up = $up > 1 ? 1 : ($up < -1 ? -1 : $up);

$ticket = getUsrParam("ticket", '', $_SESSION);
$service = getUsrParam("loginservice", 0, $_SESSION);
$user = isLoggedIn($ticket, $service) 
    ? getUserInfo($ticket, $service) 
    : die(getJsonObject(array('succes' => false, 'loggedin' => false)));

$query = "SELECT * FROM votes WHERE user_id=".$user['id']." && post_id=".$pid;
$result = mysql_query($query);
if (!$result || mysql_num_rows($result) > 0)
    die(getJsonObject(array('succes' => false, 'loggedin' => true, 'error' => 'doublevote')));
   
$query = "UPDATE posts SET score=score+$up WHERE id = ".mysql_real_escape_string($pid)." LIMIT 1";
mysql_query($query, $dbcon);
if (!$result)
    die(getJsonObject(array('succes' => false, 'loggedin' => true, 'error' => 'database')));
$query = "INSERT INTO votes (user_id, post_id) VALUES (".$user['id'].", $pid)";
mysql_query($query, $dbcon);

echo getJsonObject(array( 
  'succes' => true
  ));

?>

