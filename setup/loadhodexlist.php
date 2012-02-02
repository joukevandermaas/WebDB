<?php
require("../tools/connectdb.php");
include("../tools/hodex.php");
include("../tools/helperfuncs.php");

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
    
    $query = "INSERT IGNORE INTO orgs (id, name, horgid)\nVALUES\n";
    foreach($index as $link) {
        $query .= "(NULL, '".$names[$link["orgId"]]."', '".$link["orgId"]."'),\n";
    }
    $query = rtrim($query, ",\n");
    $result = mysql_query($query, $dbcon);
    if (!$result) { die (getJsonObject(array('succes' => false, 'error' => 'database')));}
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

$hodexLoc = "http://hodex.nl/hodexDirectory.xml";
$index = loadHodexIndex($hodexLoc);
print_r($index);
fillOrgs($index);

$ids = getIdMap();

$orgObjects = array();
$i = 0;
foreach($index as $org) {
    $orgObjects[$i++] = array(
        'id' => $ids[$org['orgId']],
        'url' => $org['url']
    );
}
echo getJsonObject(
    array(
        'succes' => true,
        'orgs' => "\n".getJsonArray($orgObjects, true, 1)
    ), false
);

?>
