<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="CSS.css">
<title>Keuze pagina</title>
</head>

<body><div class="rand">
<h1><div class="logo">Straks de header</div></h1>

<?php
include 'hodex.php';
$organisatie = null;
$url = null;

if(isset($_GET["organisatie"])){
	
	$url = htmlspecialchars($_GET["test"]);
	$organisatie = htmlspecialchars($_GET["organisatie"]);
	echo "<div class='title_grd'><h2> Studies van: ".$organisatie."</h2></div>";
	$instellingen = loadHodexSchool($url);
} else {
	echo "<div class='title_grd'><h2>Universiteiten</h2></div>";
	if(isset($_GET["test"])){
		$url = htmlspecialchars($_GET["test"]);
	} else {
		$url = 'http://www.hodex.nl/hodexDirectory.xml';
	}
	$instellingen = loadHodexIndex($url);
}

//echo count($instellingen);
echo "<h3>Maak een keuze:</h3><ul class='posts'>";
$count = count($instellingen);
for($i =0; $i<$count; $i++){
	if($i%2 == 0){
	//echo "<p class='postBlauw'>";
	echo "<li>";
	} else {
	//echo "<p class='grijs'>";
	echo "<li class='inspringR'>";
	}
	if($organisatie != null){
		$Studie = loadHodexProgram($instellingen[$i]['url']);
		echo "<a href='Studiepagina.php?test=".$instellingen[$i]['url']."'>".$Studie['name']."</a> <br />";
	} else {
		echo "<a href='?test=".$instellingen[$i]['url']."&organisatie=".$instellingen[$i]['orgId']."'>".$instellingen[$i]['orgId']."</a> <br />";
	}
		
	echo "</li>";
}
echo "</ul>";
?>

</div></p>

</div></body>

