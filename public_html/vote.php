<?php
require("connectdb.php");

$pid = $_GET["pid"];
$up = $_GET["up"];


$query = "SELECT score FROM posts WHERE id = ".mysql_real_escape_string($pid)." LIMIT 1";

$r = mysql_query($query, $dbcon);

$row = mysql_fetch_assoc($r);
$score = $row["score"];

$newscore = $score + $up;
$query = "UPDATE posts SET score=". $newscore ." WHERE id = ".mysql_real_escape_string($pid)." LIMIT 1";

mysql_query($query, $dbcon);
?>
