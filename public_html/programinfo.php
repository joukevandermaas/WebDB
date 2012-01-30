<?php
include_once('tools/loadprogram.php');
$pageName = "Meer info";
$path = array(
    'Home' => 'index.php',
    'Opleidingen' => 'programlist.php?level='.$program['level'],
    $program['name'] => 'program.php?id='.$program['id']
);
include('header.php');

$hodexurl = $program['hodexurl']; 

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

echo "<h4>".$program['name']."</h4>\n";
echo "<p class='intro'>".$info['summary']."<br />".$info['description']."</p>";
if (!empty($others)) {
    echo "<ul>";
    foreach($others as $x);
        echo "<li>$x</li>";
    echo "</ul>";
}

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
<a href='http://".$info['url']."'> bekijke de site </a>
</li>

<br />

<h4 style='padding: 0em 0em;'> vakken </h4>

<li>";


$courses = $info['courses'];
$length = count($courses);
if($length != null){
echo "<ul>";
for($i = 0; $i<$length; $i++){
	if($i % 2 == 0){
		echo "<li class='inspringL'>";
	} else {
		echo "<li class='inspringR'>";
	}
	
	echo $courses[$i]['name']."<br />";
	echo $courses[$i]['description']."<br />";
	echo "<ul><li>studiepunten: ".$courses[$i]['credits']."</li>
	<li>soort vak: ".$courses[$i]['type']."</li>
	<li>toetsing: ".$courses[$i]['examKind']."</li>
	<li>in welk jaar: ".$courses[$i]['year']."</li></ul>".
	"</li>";	
	
}
echo "</ul>";
}
echo "</li></ul>";
echo "<div class='my_right_box'>";

$content = $info['contentLinks'];
$length2 = count($content);
if($length2 != null){
echo "<ul>";
for($i = 0; $i < $length2; $i++){
	if($i % 2 == 0){
		echo "<li class='inspringL'>";
	}else {
		echo "<li class='inspringR'>";
	}

	echo $content[$i]['subject']."<br />";
	echo $content[$i]['summary']."<br />";
	if($content[$i]['description'] != null){
		echo $content[$i]['description']."<br />";
	}
	echo "</li>";
}
echo "</ul>";
}

echo "</div>";

?>
</div></body></html>
