<?php
set_time_limit(0);
ignore_user_abort();
require("../tools/connectdb.php");
include("../tools/hodex.php");

function fillOrgs($index) {
    global $dbcon;
    
    $names = array(
        "ut" => "Universiteit Twente",
        "uu" => "Universiteit Utrecht",
        "um" => "Maastricht University",
        "hg" => "Hanzehogeschool",
        "uvt" => "Tilburg University",
        "tue" => "TU Eindhoven",
        "lei" => "Universiteit Leiden",
        "rug" => "Rijksuniversiteit Groningen",
        "run" => "Radboud Universiteit Nijmegen",
        "uva" => "Universiteit van Amsterdam",
        "eur" => "Erasmus Universiteit Rotterdam",
        "wur" => "Wageningen University",
        "tud" => "TU Delft",
        "vhl" => "Van Hall-Larenstein",
        "vu" => "Vrije Universiteit Amsterdam",
        "fontys" => "Fontys Hogescholen",
        "hro" => "Hogeschool Rotterdam",
        "hhs" => "De Haagse Hogeschool", 
        "hva" => "Hogeschool van Amsterdam", 
        "nhtv" => "NHTV Breda", 
        "icra" => "ICRA", 
        "hu" => "Hogeschool Utrecht", 
        "artez" => "ArtEZ hogeschool voor de kunsten"
    );
    
    $query = "INSERT INTO orgs (id, name, horgid)\nVALUES\n";
    foreach($index as $link) {
        $query .= "(NULL, '".$names[$link["orgId"]]."', '".$link["orgId"]."'),\n";
    }
    $query = rtrim($query, ",\n");
    mysql_query($query, $dbcon);
}
function fillProgs($programs) {
    global $dbcon;
    $query = "INSERT INTO programs ".
        "(id, org_id, hprogramid, croho, name, summary, level, hodexurl)".
        "\nVALUES\n";
    foreach($programs as $prog) {
        $query .= "(NULL, ".$prog["org_id"].", '".$prog["hprogramid"].
            "', ".$prog["croho"].", '".$prog["name"]."', '".$prog["summary"].
            "', '".$prog["level"]."', '".$prog["hodexurl"]."'),\n";
    }
    $query = rtrim($query, ",\n");
    $result = mysql_query($query, $dbcon);
    if (!$result)
        die("invalid query: ".mysql_error()."\n$query");
}

function getIdMap() {
    global $dbcon;
    $query = "SELECT horgid, id FROM orgs";
    $result = mysql_query($query, $dbcon);

    $ids = array();
    while($row = mysql_fetch_assoc($result))
    {
        $ids[$row["horgid"]] = $row["id"];
    }
    return $ids;
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
function getCroho($crohoString) {
    if (empty($crohoString))
        return "NULL";
    return $crohoString;
}


$hodexLoc = "http://hodex.nl/hodexDirectory.xml";
$index = loadHodexIndex($hodexLoc);
fillOrgs($index);


$ids = getIdMap();

foreach($index as $org) {
    $orgIndex = loadHodexSchool($org["url"]);
    
    $programs = array();
    $i = 0;
    foreach($orgIndex as $program) {
        $progIndex = loadHodexProgram($program["url"]);
        $progInfo = array(
            "org_id" => $ids[$org["orgId"]],
            "hprogramid" => $program["programId"],
            "croho" => getCroho($progIndex["croho"]),
            "name" => htmlspecialchars($progIndex["name"], ENT_QUOTES),
            "summary" => htmlspecialchars($progIndex["summary"], ENT_QUOTES),
            "level" => getLevel($progIndex["level"]),
            "hodexurl" => $program["url"]
        );
        $programs[$i++] = $progInfo;
    }
    fillProgs($programs);
}
header("Location: configposts.php");
?>