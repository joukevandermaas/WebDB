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
echo "<p class='intro'>".$info['summary']." ".$info['description']."</p>";
if (!empty($others)) {
    echo "<ul>";
    foreach($others as $x);
        echo "<li>$x</li>";
    echo "</ul>";
}
?>
</div></body></html>
