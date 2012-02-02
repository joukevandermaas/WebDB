<?php
session_start();
include '../tools/helperfuncs.php';
require '../tools/connectdb.php';

// getUsrParam escapes the params from $_POST
$text = getUsrParam('text', '', $_POST);
$title = getUsrParam('title', '', $_POST);
$postId = getUsrParam('id', 0, $_POST);

// ensure the user is logged in before he can post
$userId = getUsrParam('user', 0, $_SESSION);
if ($userId === 0)
    die(getJsonObject(array(
        'succes' => false,
        'loggedin' => false
    )));

$user = getUserInfo($userId);

// the user has to enter a title and some text
if ($text === '' || $title === '') {
    die (getJsonObject(array(
        'succes' => false,
        'loggedin' => true,
        'error' => 'message'
    )));
}
// We don't want any ghost posts (with no program).
// The database actually enforces this, but there's no
// need to query it if we know it will fail.
if ($postId === 0) {
    die(getJsonObject(array(
        'succes' => false,
        'loggedin' => true,
        'error' => 'pid'
    )));
}


// replace newlines with html
$text = str_replace("\n", '<br />', $text);

// check for regular, image or video links
$link = ''; 
$type = 'text';
// regular expression from http://css-tricks.com/snippets/php/find-urls-in-text-make-links/
$reg_exUrl = "/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
// find all url's
if(preg_match_all($reg_exUrl, $text, $matches)) {
    foreach($matches[0] as $match) {
        $type = getPostType($match, $link); // check if it's an image, a video or neither
        if ($type != 'text')
            $text = str_replace($match, '', $text); // remove the link if it's an image or a video
            // you can only add one video or image per post (others will be removed)
        else // for text, just make the link clickable
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
// no need to send the content back to the client; it's already there
echo getJsonObject(array(
    'succes' => true,
    'user' => $user['firstname'].' '.$user['lastname'],
    'id' => $postId,
    'type' => $type,
    'content_link' => $link
));


?>
