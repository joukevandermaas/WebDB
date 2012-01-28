
<?php
$pageName = "Post";
$path = array(
    'Home' => 'index.php'
);

include('header.php');

$currentpostid = getUsrParam('id', 0);
$query = "SELECT posts.*, COUNT(comments.id) AS comment_count ".
    "FROM posts JOIN (comments, users) ".
    "ON (comments.post_id = posts.id) ".
    "WHERE posts.id=$currentpostid ".
    "LIMIT 1";

$result = mysql_query($query);
if (!$result) die('Invalid query '.$query);
$post = mysql_fetch_assoc($result);

$txt = $post['content'];

echo "<h4>".$post['title']."</h4>
<div class='intro'>".$post['content']."
<ul class='reacties'><li>comments: ".$post['comment_count']." </li> <li>user: ".$post['user_id']." </li> <li>time: ".$post['timestamp']."</li></ul>
</div>

<h4>Reacties</h4><ul id='comments'></ul>";
?>
<script type="text/javascript">
loadContent(<?php echo $post['id']; ?>, 0, 'comment');
</script>
<?php

echo "<div class='tekstbox'>
	<class = form method='post'>
<textarea name='comments' cols='60'rows='15'>
</textarea><br>
<input type='submit' value='Submit'/>
</form>"
?>
</div></body>
</html>
