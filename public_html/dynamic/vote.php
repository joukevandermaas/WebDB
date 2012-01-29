<?php
session_start();
include '../tools/helperfuncs.php';
require '../tools/connectdb.php';

$pid = getUsrParam("pid", 0);
$up = getUsrParam("value", 0);

$ticket = getUsrParam("ticket", '', $_SESSION);
$service = getUsrParam("loginservice", 0, $_SESSION);
$user = isLoggedIn($ticket, $service) 
    ? getUserInfo($ticket, $service) 
    : die(getJsonObject(array('succes' => false, 'loggedin' => false)));

$query = "SELECT * FROM votes WHERE user_id=".$user['id']." && post_id=".$pid;
$result = mysql_query($query);
if (!$result || mysql_num_rows($result) > 0)
    die(getJsonObject(array('succes' => false, 'loggedin' => true)));

$query = "SELECT score FROM posts WHERE id = ".mysql_real_escape_string($pid)." LIMIT 1";

$r = mysql_query($query, $dbcon);

$row = mysql_fetch_assoc($r);
$score = $row["score"];

$newscore = $score + $up;
$query = "UPDATE posts SET score=". $newscore ." WHERE id = ".mysql_real_escape_string($pid)." LIMIT 1";
mysql_query($query, $dbcon);
if (!$result)
    die(getJsonObject(array('succes' => false, 'loggedin' => true)));
$query = "INSERT INTO votes (user_id, post_id) VALUES (".$user['id'].", $pid)";
mysql_query($query, $dbcon);

echo getJsonObject(array( 
  'succes' => true
  ));

?>

