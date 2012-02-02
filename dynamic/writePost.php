<?php
session_start();
include '../tools/helperfuncs.php';
require '../tools/connectdb.php';

$text = getUsrParam('text', '', $_POST);
$title = getUsrParam('title', '', $_POST);
$postId = getUsrParam('id', 0, $_POST);

$userId = getUsrParam('user', 0, $_SESSION);
if ($userId === 0)
    die(getJsonObject(array(
        'succes' => false,
        'loggedin' => false
    )));

$user = getUserInfo($userId);

if ($text === '' || $title === '') {
    die (getJsonObject(array(
        'succes' => false,
        'loggedin' => true,
        'error' => 'message'
    )));
}
if ($postId === 0) {
    die(getJsonObject(array(
        'succes' => false,
        'loggedin' => true,
        'error' => 'pid'
    )));
}

$link = ''; 
$type = 'text';
// regular expression from http://css-tricks.com/snippets/php/find-urls-in-text-make-links/
$reg_exUrl = "/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
if(preg_match_all($reg_exUrl, $text, $matches)) {
    //print_r($matches[0]);
    foreach($matches[0] as $match) {
        $type = getPostType($match, $link);
        if ($type != 'text')
            $text = str_replace($match, '', $text);
        else
            $text = str_replace($match, "<a href=\"{$match}\">{$match}</a> ", $text);
    }
}
    
$query = "INSERT INTO posts (program_id, user_id, title, content, type, content_link) ".
    "VALUES ($postId, ".$userId.", '".$title."', '".$text."', '".$type."', '".$link."')";
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
    'id' => $postId,
    'type' => $type,
    'content_link' => $link
));


?>
