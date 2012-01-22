<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="CSS.css">
<title>Studie pagina</title>
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
include 'hodex.php';
include 'posts.php';
$url = htmlspecialchars($_GET["test"]);

$studie = loadHodexProgram($url);

"<!-- titel van de pagina, studie naam uit xml bestand -->";
echo "<h2>".$studie['name']."</h2>";
echo "</div>";
echo "<ul class='breadcrumbs'>
    <li><a href='index.html'>Home</a></li>
    <li><a href='keuzepagina.php'bachelor''>Keuzepagina</a></li>
    <li class='current'><a href='Studiepagina.php'>".$studie['name']."</a></li>
	</ul>";

echo "<div class='opleidingPlaatje'><img src='http://www.historyking.com/images/Future-Of-Nanotechnology-Artificial-Intelligence.jpg' class='opleidingPlaatje'></div>";

echo "<h4>Introductie</h4>";

// dit is de xml informatie over de studie

echo "<p class='intro'><div class='intro_grd'>"
.$studie['summary'].
"<br />"
.$studie['description'].
//<!-- straks een link naar de 'Statische studieinformatie' pagina -->
"<br />
<a href='http://www.studeren.uva.nl/ki' target='_blank' title='klik hier!'> meer studie informatie </a>
</div></p>";


echo "<h4>Posts</h4>";
// de 5 best beoordeelde of meest recente gedeelde dingen
echo "<ul class='posts'>";

setNumberOfPosts(5);
$posts = postsProgram(20);
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
?>


<h3>Deel iets!</h3>
<p class="txtField">
Txtfield voor een reactie.<br />
nog meer txtfield.
</p>

<!-- link naar de 'archief' pagina met meer gedeelde content -->
<p><a href="archief.html">klik voor meer</a></p>
</div></body>
</html>