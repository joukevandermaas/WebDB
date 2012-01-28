<?php
session_start();
require("../tools/connectdb.php");
include("../tools/helperfuncs.php");

$pid = getUsrParam("pid", 0);
$up = getUsrParam("value", 0);
$ticket = getUsrParam("ticket", '', $_SESSION);
$service = getUsrParam("loginservice", 0, $_SESSION);
$user = isLoggedIn($ticket, $service) ? getUserInfo($ticket, $service) : die('{ "succes": false }');

$query = "SELECT * FROM votes WHERE user_id=".$user['id']." && post_id=".$pid;
$result = mysql_query($query);
if (!$result || mysql_num_rows($result) > 0)
    die('{ "succes": false }');

$query = "SELECT score FROM posts WHERE id = ".mysql_real_escape_string($pid)." LIMIT 1";

$r = mysql_query($query, $dbcon);

$row = mysql_fetch_assoc($r);
$score = $row["score"];

$newscore = $score + $up;
$query = "UPDATE posts SET score=". $newscore ." WHERE id = ".mysql_real_escape_string($pid)." LIMIT 1";
mysql_query($query, $dbcon);
if (!$result)
    die('{ "succes": false }');
$query = "INSERT INTO votes (user_id, post_id) VALUES (".$user['id'].", $pid)";
mysql_query($query, $dbcon);

echo "{\n". 
  "  \"succes\": true,\n".
  "  \"ticket\": \"$ticket\",\n".
  "  \"service\": \"$service\"\n".
  "}";

?>

