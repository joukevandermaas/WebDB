<?php
$pageName = "Post";
$path = array(
    'Home' => 'index.php'
);

include('../public_html/header.php');
include('posts.php');
$query="SELECT * FROM posts WHERE id= 1288 LIMIT 1";

$posts = mysql_query($query);
$post = MySql_fetch_row($posts);
$iets = $post['id'][0];
echo $iets;
//$post = getPost($posts, 0);

echo "<h4>".$post['title']."</h4>
<!-- dit is de xml informatie over de studie -->
<div class='intro_grd'><p class='intro'>"

.$post['content'].

"
<ul class='reacties'><li>commends: ".$post['comment_count']." </li> <li>user: ".$post['user_id']." </li> <li>time: ".$post['time']."</li></ul>
</li>


</p></div>

<h4>REACTIES</h4>"
//<!-- de 5 best beoordeelde of meest recente gedeelde dingen -->
.$count = 1 . 

"<ul class='posts'>";
for($i = 0; $i<$count; $i++){
	if($i %2 == 0){
		echo "<li class='inspringL'><h5>content1</h5>";
	} else {
		echo "<li class='inspringR'><h5>content2</h5>";
	}
	
	// plaats hier je functie of je print.

echo "</li>";
}
echo "</ul>

<!-- link naar de 'archief' pagina met meer gedeelde content -->
<p><a href='archief.html'>klik voor meer</a></p>";
?>
</div></body>
</html>