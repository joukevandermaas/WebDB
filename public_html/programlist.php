<?php

include("header.php");

function getGetParam($name, $default) {
    if (isset($_GET[$name]))
        return mysql_real_escape_string($_GET[$name]);
    return $default;
}
function getShortString($string, $maxLength) {
    if (strlen($string) > $maxLength) {
        return substr($string, 0, $maxLength - 3)."...";
    }
    return $string;
}

$level = getGetParam("level", 3);
$org = getGetParam("org", -1);

$levelName = "";
switch($level) {
    case '1':
        $levelName = "Bachelor (HBO)";
        break;
    case '2':
        $levelName = "Master (HBO)";
        break;
    case '3':
        $levelName = "Bachelor";
        break;
    case '4':
        $levelName = "Master";
        break;
}

$query = "SELECT programs.id, programs.name, orgs.id, orgs.name\n".
        " FROM programs\n".
        " JOIN (orgs) ON (programs.org_id=orgs.id)\n".
        " WHERE level=".$level."\n";
$result = mysql_query($query, $dbcon);
$pcount = mysql_num_rows($result);
if (!$result)
    die("Invalid query: ".mysql_error());
    
$programs = array();
while($row = mysql_fetch_row($result)){
    $programs[$row[3]][$row[0]] = $row[1];
}
?>


<h2 class="title_grd"><?php echo $levelName; ?>opleidingen</h2>
<ul class="breadcrumbs">
    <li><a href="index.html">Home</a></li>
    <li><a href="programlist.php?level=<?php echo $level; ?>"><?php echo $levelName; ?>opleidingen</a></li>
</ul>
<?php
foreach($programs as $org => $plist) {
    echo "<div class='org'>\n<h4>$org</h4>\n<ul>\n";
    foreach($plist as $id => $program) {
        echo "<li><a href='program.php?id=$id'>".getShortString($program, 50)."</a></li>\n";
    }
    echo "</ul>\n</div>";
}
?>
</div></body></html>
