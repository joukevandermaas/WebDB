<?php
session_start();
include '../tools/helperfuncs.php';
require '../tools/connectdb.php';

$pid = getUsrParam("pid", 0);
$up = getUsrParam("value", 0);

// You only have 1 vote, so $up can only be 1 (upvote) or -1 (downvote).
// Any other values must be normalized
$up = $up > 1 ? 1 : ($up < -1 ? -1 : $up);

// Make sure the user is logged in
$userId = getUsrParam('user', 0, $_SESSION);
if ($userId === 0)
    die(getJsonObject(array(
        'succes' => false,
        'loggedin' => false
    )));

// Make sure the user hasn't voted on this item before
$query = "SELECT * FROM votes WHERE user_id=".$userId." && post_id=".$pid;
$result = mysql_query($query);
if (!$result || mysql_num_rows($result) > 0)
    die(getJsonObject(array('succes' => false, 'loggedin' => true, 'error' => 'doublevote')));

// Actually cast the vote
$query = "UPDATE posts SET score=score+$up WHERE id = ".mysql_real_escape_string($pid)." LIMIT 1";
mysql_query($query, $dbcon);
if (!$result)
    die(getJsonObject(array('succes' => false, 'loggedin' => true, 'error' => 'database')));

// ensure the user doesn't vote again
$query = "INSERT INTO votes (user_id, post_id) VALUES (".$userId.", $pid)";
mysql_query($query, $dbcon);

// succes!
echo getJsonObject(array( 
  'succes' => true
  ));

?>

