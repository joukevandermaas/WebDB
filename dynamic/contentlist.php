<?php
require '../tools/connectdb.php';
include '../tools/helperfuncs.php';

// This file works for the comments and for the posts,
// but some things are different. One of them is the query.
function getQuery($type, $id, $start, $count) {
    if ($type === 'post')
        return getPostQuery($id, $start, $count);
    elseif ($type === 'comment')
        return getCommentQuery($id, $start, $count);

    $result = mysql_query($query, $dbcon);
    if (!$result)
        return false;
    else 
        return getMysqlArray($result);
}
function getPostQuery($id, $start, $count) {
    return 
        "SELECT posts.*, ".
            "users.firstname, ".
            "users.lastname ".
        "FROM posts JOIN (users) ".
            "ON (posts.user_id=users.id) ".
        "WHERE program_id=$id ".
        "GROUP BY posts.id ".
        "ORDER BY ".
            "posts.timestamp DESC, ". // order by time and score (newer is more important)
            "(1- (score/posts.timestamp)) ASC ".
        "LIMIT $start, $count";
}
function getCommentQuery($id, $start, $count) {
    return "SELECT comments.*, users.firstname, users.lastname ".
        "FROM comments JOIN users ON (users.id=comments.user_id) ".
        "WHERE post_id=$id ".
        "ORDER BY timestamp DESC ". // comments don't have a score
        "LIMIT $start, $count";
}

// getUsrParam escapes the values from the $_GET array
$type = getUsrParam('type', 'post');
$limitLength = getUsrParam('climit', 0);

$itemsPerPage = 4;
$page = getUsrParam('page', 0);
$id = getUsrParam('id', 0);

$start = $page * $itemsPerPage;
$query = getQuery($type, $id, $start, $itemsPerPage);

$result = mysql_query($query, $dbcon);
$items = $result ? getMysqlArray($result) : die('[]');
$jsonOutput = getJSONArray($items, true, 0, $limitLength);

echo $jsonOutput;

?>
