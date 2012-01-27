
<?php
$pageName = "Post";
$path = array(
    'Home' => 'index.php'
);

include('header.php');
include('comments.php');

$currentpostid = getUsrParam('id', 0);
$query = "SELECT * FROM posts WHERE id=$currentpostid LIMIT 1";

$result = mysql_query($query);
if (!$result) die('Invalid query');
$post = mysql_fetch_assoc($result);

$txt = $post['content'];

echo "<h4>".$post['title']."</h4>
<!-- dit is de xml informatie over de studie -->
<div class='intro'>".$post['content']."
<ul class='reacties'><li>comments: ".$post['comment_count']." </li> <li>user: ".$post['user_id']." </li> <li>time: ".$post['time']."</li></ul>
</div>

<h4>REACTIES</h4>";
$totalcomments = "SELECT * FROM comments WHERE post_id = $currentpostid";
$count = mysql_query($totalcomments);
$kaas = mysql_num_rows($count);



echo "<ul class='posts'>";
for($i = 0; $i<$kaas; $i++){
	if($i %2 == 0){
		echo "<li class='inspringL'>";
	} else {
		echo "<li class='inspringR'>";
	}
	
	// plaats hier je functie of je print.

	

$comment = getComments($count, $i);	
echo 
"<div class='intro'>".$comment['content']."
<ul class='reacties''><li>user: ".$comment['user_id']." </li> <li>time: ".$comment['time']."</li></ul>
</div>";
echo "</li>";
}
echo "</ul><br /><br />";

echo "<div class='tekstbox'>
	<class = form method='post'>
<textarea name='comments' cols='60'rows='15'>
</textarea><br>
<input type='submit' value='Submit'/>
</form>"
?>
</div></body>
</html>
