<?php
$pageName = "Post";
$path = array(
    'Home' => 'index.php'
);

include('header.php');
include('posts.php');
$query = "SELECT * FROM posts WHERE id= 2 LIMIT 1";

$posts = mysql_query($query);
$post = getPost($posts, 0);

$txt = $post['content'];

echo "<h4>".$post['title']."</h4>
<!-- dit is de xml informatie over de studie -->
<div class='intro'>".$post['content']."
<ul class='reacties'><li>commends: ".$post['comment_count']." </li> <li>user: ".$post['user_id']." </li> <li>time: ".$post['time']."</li></ul>
</div>

<h4>REACTIES</h4>";
//<!-- de 5 best beoordeelde of meest recente gedeelde dingen -->
$count = 1;

echo "<ul class='posts'>";
for($i = 0; $i<$count; $i++){
	if($i %2 == 0){
		echo "<li class='inspringL'><h5>content1</h5>";
	} else {
		echo "<li class='inspringR'><h5>content2</h5>";
	}
	
	// plaats hier je functie of je print.

echo "</li>";
}
echo "</ul><br /><br />";
?>
</div></body>
</html>