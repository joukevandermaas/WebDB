<?php
// loads a program from the database
include_once('tools/loadprogram.php');
$pageName = "Meer info";

$path = array(
    'Home' => 'index.php',
    'Opleidingen' => 'programlist.php?level='.$program['level'],
    $program['org_name'] => 'programlist.php?id='.$program['org_id'],
    $program['name'] => 'program.php?id='.$program['id']
);

include('header.php');

// this file uses the xml from hodex directly, so we need to parse it
include('tools/hodex.php');
$hodexurl = $program['hodexurl']; 
$info = loadHodexProgram($hodexurl);

// croho is the same for the same program within different organizations
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

// echo all the info
echo "<div class='margin'><h4>".$program['name']."</h4>\n";
echo "<p class='intro'>".htmlentities($info['summary'])."<br />".htmlentities($info['description'])."</p>";
if (!empty($others)) {
    echo "<ul>";
    foreach($others as $x);
        echo "<li>$x</li>";
    echo "</ul>";
}

echo "<div class='my_right_box'>";

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

// print the courses within the program
$courses =$info['courses'];
$length = count($courses);
if($length != null){
echo "<ul class='vak'>";

for($i = 0; $i<$length; $i++){
	// the odd programs have a different color
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
