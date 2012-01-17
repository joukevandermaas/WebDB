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
$url = htmlspecialchars($_GET["test"]);
$organisatie = htmlspecialchars($_GET["organisatie"]);

if($organisatie == null){
	echo "<div class='title_grd'><h2>Universiteiten</h2></div>";
	if($url == null){
	$url = 'http://www.hodex.nl/hodexDirectory.xml';
	}
	$instellingen = loadHodexIndex($url);
} else if($organisatie != null){
	echo "<div class='title_grd'><h2> Studies van: ".$organisatie."</h2></div>";
	$instellingen = loadHodexSchool($url);
}

//echo count($instellingen);
echo "<h3>Maak een keuze:</h3>";
echo "<table border='1'><tr><td>";
for($i =0; $i<count($instellingen); $i++){
	if($i == intval((count($instellingen)+1)/2)){
		echo "</td><td>";
	}
	if($organisatie == null){
	
		echo "<a href='?test=".$instellingen[$i][url]."&organisatie=".$instellingen[$i][orgId]."'>".$instellingen[$i][orgId]."</a> <br />";
	} else{
		$Studie = loadHodexProgram($instellingen[$i][url]);
		echo "<a href='Studiepagina.php?test=".$instellingen[$i][url]."'>".$Studie[name]."</a> <br />";
	}
}
echo "</td></tr></table>";
?>

</div></p>

</div></body>

