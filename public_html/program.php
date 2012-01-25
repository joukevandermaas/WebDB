<?php
include 'tools/helperfuncs.php';
include 'tools/posts.php';
require 'tools/connectdb.php'; 
include 'tools/loadprogram.php';

?>

<?php
$pageName = $program["name"];
$path = array ("Home" => "index.php", "Opleidingen" => "programlist.php?level=".$program['level']);
include("header.php"); 
?>

<script>
function sendRequest() {
new Ajax.Request("testAjax.php", 
	{ 
		method: 'post', 
		postBody: 'title='+ $F('title') +'&text='+ $F('text'),
		onComplete: showResponse 
	});
}

function showResponse(req){
	$('show').innerHTML= req.responseText;
}
</script>

<?php
echo "<div class='opleidingPlaatje'><img src='http://www.historyking.com/images/Future-Of-Nanotechnology-Artificial-Intelligence.jpg' class='opleidingPlaatje'></div>";

echo "<h4>Introductie</h4>";

// dit is de xml informatie over de studie

echo "<p class='intro'>"
.$program['summary'].
"<br />
<br />
<a href='programinfo.php?id=".$program['id']."'>Meer studieinformatie</a>
</p>";


echo "<h4>Posts</h4>";
// de 5 best beoordeelde of meest recente gedeelde dingen
echo "<ul class='posts'>";

setNumberOfPosts(5);
$posts = postsProgram($program['id']);
$aantal = mysql_numrows($posts);

for($i = 0; $i < $aantal; $i++){
$arr = getPost($posts, $i);

echo $i%2 == 0 ? "<li>" : "<li class='inspringR'>";

echo "<ul class='thumbs'><li><img src='img/thumbsup.png'></li> <li><img src='img/thumbsdown.png'></li></ul><h5>".$arr['title']."</h5>
".$arr['content']."
<ul class='reacties'><li>comments: ".$arr['comment_count']." </li> <li>user: ".$arr['user_id']." </li> <li>time: ".$arr['time']."</li></ul>
</li>";
}

echo "</ul>";

echo "<div id='show'>
	<form id='test' onsubmit='return false;'>
		<h3>Deel wat leuks door hier te typen</h3>
		Title: <input type='text' name='title' id='title' size='40'><br />
		<input type='text' name='text' id='text'  size='146'><br />
		<input type='submit' value='submit' onClick='sendRequest()'>
	</form>
</div>";

?>

<!-- link naar de 'archief' pagina met meer gedeelde content -->
<p><a href="archief.html">klik voor meer</a></p>
</div></body>
</html>
