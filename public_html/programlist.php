<?php

include("header.php");

function getGetParam($name, $default) {
    if (isset($_GET[$name]))
        return mysql_real_escape_string($_GET[$name]);
    return $default;
}

$level = getGetParam("level", 3);
$page = getGetParam("page", 0);
$programsPerPage = 25;

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

$limitStart = $programsPerPage * $page;
$query = "SELECT programs.id, programs.name, orgs.name, programs.croho, programs.hprogramid".
        " FROM programs JOIN (orgs) ON (programs.org_id=orgs.id)".
        " WHERE level=".$level.
        //" GROUP BY programs.croho".
        " ORDER BY programs.name".
        " LIMIT ".(string)($programsPerPage * $page).", ".$programsPerPage;

$result = mysql_query($query, $dbcon);
$pcount = mysql_num_rows($result);
if (!$result)
    die("Invalid query: ".mysql_error());
?>


<h2 class="title_grd">Kunstmatige Intelligentie</h2>
<ul class="breadcrumbs">
    <li><a href="index.html">Home</a></li>
    <li><a href="programlist.php?level=<?php echo $level; ?>"><?php echo $levelName; ?>opleidingen</a></li>
</ul>
<h4><?php echo $levelName; ?></h4>
<ul>
<?php
    while($row = mysql_fetch_row($result)) {
        echo "<!--"; print_r($row); echo "-->";
        echo "<li>".htmlspecialchars($row[1])." (".$row[2].")</li>\n";
    }
?>
</ul>
<?php
if ($page > 0) {
    echo "<a href='programlist.php?level=$level&page=".(string)(--$page)."'>Vorige</a>";
}
if ($pcount >= $programsPerPage) {
    echo "<a href='programlist.php?level=$level&page=".(string)(++$page)."'>Volgende</a>";
}
?>
</div></body></html>
