<?php
set_time_limit(0); // loading a lot of xml files is slow
include('../tools/helperfuncs.php');
include('../tools/hodex.php');

function getCroho($crohoString) {
    if (empty($crohoString)) // croho might not be defined
        return "NULL";
    return $crohoString;
}
function getLevel($levelString) {
    switch($levelString) {
        case "bachelor":
            return '1';
        case "master":
            return '2';
        case "academic bachelor":
            return '3';
        case "academic master":
            return '4';
    }
}

// getUsrParam escapes user input
$orgId = getUsrParam('id', 0);
$url = getUsrParam('url', '');

// make sure the params are valid
if ($orgId == 0 || $url == '') {
    die(getJsonObject(array(
        'succes' => false,
        'error' => 'params'
    )));
}

$orgIndex = loadHodexSchool($url);

$programs = array();
$i = 0;
// load all relevant info into an array first
foreach($orgIndex as $programInfo) {
    $progHodex = loadHodexProgram($programInfo["url"]);
    if ($progHodex === false) // couldn't be loaded
        continue;

    $progDatabase = array(
        "org_id" => $orgId,
        "hprogramid" => $programInfo["programId"],
        "croho" => getCroho($progHodex["croho"]),
        "name" => htmlentities($progHodex["name"], ENT_QUOTES),
        "summary" => htmlentities($progHodex["summary"], ENT_QUOTES),
        "level" => getLevel($progHodex["level"]),
        "hodexurl" => $programInfo["url"]
    );
    $programs[$i++] = $progDatabase;
}

// INSERT IGNORE so this works when there's new information (no duplicate key errors)
$query = "INSERT IGNORE INTO programs ".
    "(id, org_id, hprogramid, croho, name, summary, level, hodexurl)".
    "\nVALUES\n";
foreach($programs as $prog) {
    $query .= "(NULL, ".$prog["org_id"].", '".$prog["hprogramid"].
        "', ".$prog["croho"].", '".$prog["name"]."', '".$prog["summary"].
        "', '".$prog["level"]."', '".$prog["hodexurl"]."'),\n";
}
$query = rtrim($query, ",\n"); // remove the last comma
$result = mysql_query($query, $dbcon);
if (!$result) {
    die(getJsonObject(array('succes' => false, 'error' => 'database')));}

echo getJsonObject(array(
    'succes' => true,
    'loaded' => count($programs)
));
    
?>
