<?php
include('tools/helperfuncs.php');
include('tools/programfilter.php');

function getOrgName($id) {
    global $dbcon;
    $result = mysql_query("SELECT name FROM orgs WHERE id=".$id, $dbcon);
    $row = mysql_fetch_row($result);
    return $row[0];
}

$level = getUsrParam("level", -1);
$org = getUsrParam("org", -1);

$filters = new ProgramFilterList();

$pageName = "";
$groupColumn = 0;
if($level < 1 && $org < 1)
    $level = 3;
if($org > 0) {
    $filters->addFilter("org_id", $org);
    $groupColumn = 4;
}
if($level > 0) {
    $filters->addFilter("level", $level);
    $groupColumn = 3;
}

$programs = $filters->getArray($groupColumn, 0);
if (!$programs)
    die("Geen opleidingen gevonden");
?>

<?php
$pageName = "";
if ($org > 0) {
    $pageName = getOrgName($org);
}
if ($level > 0) {
    $pageName = getFriendlyLevel($level)."opleidingen";
}

$path = array("Home" => "index.php");
include("header.php");
?>

<?php
foreach($programs as $group => $plist) {
    echo "<div class='org'>\n<h4>".getFriendlyLevel($group)."</h4>\n<ul>\n";
    foreach($plist as $id => $program) {
        echo "<li><a href='program.php?id=$id'>".getShortString($program[1], 50)."</a></li>\n";
    }
    echo "</ul>\n</div>";
}
?>
</div></body></html>
