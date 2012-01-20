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
$url = htmlspecialchars($_GET["test"]);

$studie = loadHodexProgram($url);

"<!-- titel van de pagina, studie naam uit xml bestand -->";
echo "<h2>".$studie['name']."</h2>";
echo "</div>";

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
?>

<h4>Posts</h4>
<!-- de 5 best beoordeelde of meest recente gedeelde dingen -->
<ul class="posts">
<li><ul class="thumbs"><li><img src="img/thumbsup.png"></li> <li><img src="img/thumbsdown.png"></li></ul><h5>content1</h5>
Computersystemen die fraude met creditcards ontdekken, een telefonische routeplanner voor de trein die gesproken taal begrijpt.
Dit zijn slechts twee voorbeelden van toegepaste kunstmatige intelligentie.
Computers ondersteunen mensen steeds vaker bij het nemen van beslissingen of het zelfstandig uitvoeren van taken waarvoor intelligentie nodig is.
Als je Kunstmatige intelligentie studeert, leer je hoe je machines zo intelligent mogelijk maakt.
<ul class="reacties"><li>commends</li> <li>Name</li> <li>Date</li></ul>
</li>
<li class="inspringR"><ul class="thumbs"><li><img src="img/thumbsup.png"></li> <li><img src="img/thumbsdown.png"></li></ul><h5>content2</h5>
Computersystemen die fraude met creditcards ontdekken, een telefonische routeplanner voor de trein die gesproken taal begrijpt.
Dit zijn slechts twee voorbeelden van toegepaste kunstmatige intelligentie.
Computers ondersteunen mensen steeds vaker bij het nemen van beslissingen of het zelfstandig uitvoeren van taken waarvoor intelligentie nodig is.
Als je Kunstmatige intelligentie studeert, leer je hoe je machines zo intelligent mogelijk maakt.
<ul class="reacties"><li>commends</li> <li>Name</li> <li>Date</li></ul>
</li>
<li><ul class="thumbs"><li><img src="img/thumbsup.png"></li> <li><img src="img/thumbsdown.png"></li></ul><h5>content3</h5>
Computersystemen die fraude met creditcards ontdekken, een telefonische routeplanner voor de trein die gesproken taal begrijpt.
Dit zijn slechts twee voorbeelden van toegepaste kunstmatige intelligentie.
Computers ondersteunen mensen steeds vaker bij het nemen van beslissingen of het zelfstandig uitvoeren van taken waarvoor intelligentie nodig is.
Als je Kunstmatige intelligentie studeert, leer je hoe je machines zo intelligent mogelijk maakt.
<ul class="reacties"><li>commends</li> <li>Name</li> <li>Date</li></ul>
</li>
<li class="inspringR"><ul class="thumbs"><li><img src="img/thumbsup.png"></li> <li><img src="img/thumbsdown.png"></li></ul><h5>content4</h5>
Computersystemen die fraude met creditcards ontdekken, een telefonische routeplanner voor de trein die gesproken taal begrijpt.
Dit zijn slechts twee voorbeelden van toegepaste kunstmatige intelligentie.
Computers ondersteunen mensen steeds vaker bij het nemen van beslissingen of het zelfstandig uitvoeren van taken waarvoor intelligentie nodig is.
Als je Kunstmatige intelligentie studeert, leer je hoe je machines zo intelligent mogelijk maakt.
<ul class="reacties"><li>commends</li> <li>Name</li> <li>Date</li></ul>
</li>
<li><ul class="thumbs"><li><img src="img/thumbsup.png"></li> <li><img src="img/thumbsdown.png"></li></ul><h5>content5</h5>
Computersystemen die fraude met creditcards ontdekken, een telefonische routeplanner voor de trein die gesproken taal begrijpt.
Dit zijn slechts twee voorbeelden van toegepaste kunstmatige intelligentie.
Computers ondersteunen mensen steeds vaker bij het nemen van beslissingen of het zelfstandig uitvoeren van taken waarvoor intelligentie nodig is.
Als je Kunstmatige intelligentie studeert, leer je hoe je machines zo intelligent mogelijk maakt.
<ul class="reacties"><li>commends</li> <li>Name</li> <li>Date</li></ul>
</li>
</ul>

<h3>Deel iets!</h3>
<p class="txtField">
Txtfield voor een reactie.<br />
nog meer txtfield.
</p>

<!-- link naar de 'archief' pagina met meer gedeelde content -->
<p><a href="archief.html">klik voor meer</a></p>
</div></body>
</html>