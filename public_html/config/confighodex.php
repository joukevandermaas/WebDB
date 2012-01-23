<?php
set_time_limit(0);
ignore_user_abort();
require("../database.php");
include("../hodex.php");

$con = getConnection();

function fillOrgs($index) {
    global $con;
    mysql_query("DELETE FROM orgs", $con);

    $query = "INSERT INTO orgs (id, name, horgid)\nVALUES\n";
    foreach($index as $link) {
        $query .= "(NULL, '', '".$link["orgId"]."'),\n";
    }
    $query = rtrim($query, ",\n");
    mysql_query($query, $con);
}
function fillProgs($programs) {
    global $con;
    $query = "INSERT INTO programs ".
        "(id, org_id, hprogramid, croho, name, summary, level, hodexurl)".
        "\nVALUES\n";
    foreach($programs as $prog) {
        $query .= "(NULL, ".$prog["org_id"].", '".$prog["hprogramid"].
            "', ".$prog["croho"].", '".$prog["name"]."', '".$prog["summary"].
            "', '".$prog["level"]."', '".$prog["hodexurl"]."'),\n";
    }
    $query = rtrim($query, ",\n");
    //echo $query . "\n\n";
    mysql_query($query, $con);
}

function getIdMap() {
    global $con;
    $query = "SELECT horgid, id FROM orgs";
    $result = mysql_query($query, $con);

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
            return 0;
        case "master":
            return 1;
        case "academic bachelor":
            return 2;
        case "academic master":
            return 3;
    }
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
        $program = $orgIndex[0];
        $progIndex = loadHodexProgram($program["url"]);
        $progInfo = array(
            "org_id" => $ids[$org["orgId"]],
            "hprogramid" => $program["programId"],
            "croho" => $progIndex["croho"],
            "name" => $progIndex["name"],
            "summary" => $progIndex["summary"],
            "level" => getLevel($progIndex["level"]),
            "hodexurl" => $program["url"]
        );
        $programs[$i++] = $progInfo;
    }
    fillProgs($programs);
}
echo "All done!";
?>