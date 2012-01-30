<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="CSS.css">
<title>Studie pagina</title>

<script type="text/javascript" src="prototype.js"></script>
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


</head>

<body><div class="rand">
<h1><div class="logo">Straks de header</div></h1>

<ul id="topnav">
<li class="inspringZ"><a class="menu" href="#home">Home</a></li>
<li class="inspringZ"><a class="menu" href="#Bacheloropleidingen">Bachelor</a></li>
<li class="inspringZ"><a class="menu" href="#Masteropleidingen">Master</a></li>
<li class="inspringZ"><a class="menu" href="#Opleiding">Instellingen</a></li>
</ul>


<?php
echo "<div class='title_grd'>";
include 'posts.php';
include 'connectdb.php';

if(isset($_GET["program_id"])){
	$program_id = htmlspecialchars($_GET["program_id"]);
}

$query = "SELECT * FROM programs WHERE id= '$program_id'";
$result = MySql_query($query);
$program = mysql_fetch_assoc($result);

"<!-- titel van de pagina, studie naam uit xml bestand -->";
echo "<h2>".$program['name']."</h2>";
echo "</div>";
echo "<ul class='breadcrumbs'>
    <li><a href='index.html'>Home</a></li>
    <li><a href='keuzepagina.php'bachelor''>Keuzepagina</a></li>
    <li class='current'><a href='Studiepagina.php'>".$program['name']."</a></li>
	</ul>";

echo "<div class='opleidingPlaatje'><img src='http://www.historyking.com/images/Future-Of-Nanotechnology-Artificial-Intelligence.jpg' class='opleidingPlaatje'></div>";

echo "<h4>Introductie</h4>";

// dit is de xml informatie over de studie

echo "<p class='intro'>"
.$program['summary'].
"<br />
<br />
<a href='http://www.studeren.uva.nl/ki' target='_blank' title='klik hier!'> meer studie informatie </a>
</p>";


echo "<h4>Posts</h4>";
// de 5 best beoordeelde of meest recente gedeelde dingen
echo "<ul class='posts'>";

setNumberOfPosts(5);
$posts = postsProgram($program_id);
$aantal = mysql_numrows($posts);

for($i = 0; $i < $aantal; $i++){
$arr = getPost($posts, $i);

if($i%2 == 0){
echo "<li><ul class='thumbs'><li><img src='img/thumbsup.png'></li> <li><img src='img/thumbsdown.png'></li></ul><h5>".$arr['title']."</h5>
".$arr['content']."
<ul class='reacties'><li>commends: ".$arr['comment_count']." </li> <li>user: ".$arr['user_id']." </li> <li>time: ".$arr['time']."</li></ul>
</li>
";} else {
echo"<li class='inspringR'><ul class='thumbs'><li><img src='img/thumbsup.png'></li> <li><img src='img/thumbsdown.png'></li></ul><h5>".$arr['title']."</h5>
".$arr['content']."
<ul class='reacties'><li>commends: ".$arr['comment_count']." </li> <li>user: ".$arr['user_id']." </li> <li>time: ".$arr['time']."</li></ul>
</li>";}
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