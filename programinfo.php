<?php
// een aantal standaard functies staan in deze php file dus altijd nodig
include_once('tools/loadprogram.php');
$pageName = "Meer info";
// dit is het spoor wat je hebt gevold om op deze pagina te komen
$path = array(
    'Home' => 'index.php',
    'Opleidingen' => 'programlist.php?level='.$program['level'],
    $program['org_name'] => 'programlist.php?id='.$program['org_id'],
    $program['name'] => 'program.php?id='.$program['id']
);
// Boven iedere pagina staat de zelfde boven kant met knoppen dus daar een apparte file van.
include('header.php');

// deze pagina heeft meer informatie nodig dan in de database staat dus daarom hodex er bij
$hodexurl = $program['hodexurl']; 

// toevoegen van speciaal geschreven functies voor hodex uit lezen
include('tools/hodex.php');

$info = loadHodexProgram($hodexurl);

$query = "SELECT programs.name, orgs.name ".
         "FROM programs JOIN orgs ON orgs.id=programs.org_id".
         "WHERE croho=".$program['croho'];
$result = mysql_query($query, $dbcon);

$others = array();
if($result){
     $i = 0;
     while($row = mysql_fetch_assoc($result)){
        $others[$i++] = $row;
    }
}

// de beschrijving van de opleiding die word bekeken
echo "<div class='margin'><h4>".$program['name']."</h4>\n";
echo "<p class='intro'>".htmlentities($info['summary'])."<br />".htmlentities($info['description'])."</p>";
if (!empty($others)) {
    echo "<ul>";
    foreach($others as $x);
        echo "<li>$x</li>";
    echo "</ul>";
}

echo "<div class='my_right_box'>";
// in de rechter kolom word wat overige informatie gegeven die nog in de hodex stond.
$content = $info['contentLinks'];
$length2 = count($content);
if($length2 != null){
echo "<ul class='vak'>";
for($i = 0; $i < $length2; $i++){
	if($i % 2 == 0){
		echo "<li class='odd'>";
	}else {
		echo "<li>";
	}

	echo htmlentities($content[$i]['subject'])."<br />";
	echo htmlentities($content[$i]['summary'])."<br />";
	if($content[$i]['description'] != null){
		echo htmlentities($content[$i]['description'])."<br />";
	}
	echo "</li>";
}
echo "</ul>";
}

echo "</div>";

// hier word wat korte info weergegeven, als land en aantal punten
echo "<ul class='linkerbox'><li class='class'>
<h5>Algemene informatie:</h5>
<ul class='uitkomstgegevens'>
<li>".$info['country']."</li>
<li>".$info['degree']."</li>
<li>".$info['credits']."</li>
<li>".$info['duration']." maanden</li>
</ul>

<ul class='gegevens'>
<li>Land: </li>
<li>verkregen titel:</li>
<li>studiepunten:</li>
<li>duur:</li>
</ul>
<!-- link naar de homepage van het instituut of de opleiding -->
<a href='http://".$info['url']."'> bekijke de site </a>
</li>

<br />

<h4 style='padding: 0em 0em;'> vakken </h4>

<li>";

// de verschillende vakken met korte beschrijving en punten die binnen deze studie worden gegeven.
$courses =$info['courses'];
$length = count($courses);
if($length != null){
echo "<ul class='vak'>";
// lus om voor iedervak op nieuw uit te printen
for($i = 0; $i<$length; $i++){
	// keuze of het aan links of rechts inspringt met bijbehorende kleur
	if($i % 2 == 0){
		echo "<li class='odd'>";
	} else {
		echo "<li>";
	}
	$str = $courses[$i]['name'];
	if(strlen($str) > 17){
		$str = substr($str,0,18)."..";
	}
	
	echo "<h5 title='".$courses[$i]['name']."'>".$str."</h5><br />";
	echo htmlentities($courses[$i]['description'])."<br />";
	echo "<ul><li>studiepunten: ".$courses[$i]['credits']."</li>
	<li>soort vak: ".$courses[$i]['type']."</li>
	<li>toetsing: ".$courses[$i]['examKind']."</li>
	<li>in welk jaar: ".$courses[$i]['year']."</li></ul>".
	"</li>";	
	
}
echo "</ul>";
}
echo "</li></ul>";

?>
</div>
</div></body></html>
