<?php
require("database.php");

$pid = $_GET["pid"];
$up = $_GET["up"];


$con = getConnection();
$query = "SELECT score FROM posts WHERE id = ".mysql_real_escape_string($pid)." LIMIT 1";

$r = mysql_query($query, $con);

$row = mysql_fetch_assoc($r);
$score = $row["score"];

$newscore = $score + $up;
$query = "UPDATE posts SET score=". $newscore ." WHERE id = ".mysql_real_escape_string($pid)." LIMIT 1";

mysql_query($query, $con);
// INSERT INTO comments (id, post_id, user_id, content, timestamp) VALUES (NULL, 1, 1, 'Hallo!', NULL)
// INSERT INTO comments SET id=NULL, post_id=1, ...
?>
