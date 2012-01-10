<?php
$programCount = 0;

function loadHodexIndex($loc) {
    $schools = loadSubHodexIndex($loc, "hodexEntity", "hodexDirectoryURL");
    
    foreach($schools as $school) {
        loadHodexSchool($school);
    }
}
function loadHodexSchool($loc) {
    $programs = loadSubHodexIndex($loc, "hodexResource", "hodexResourceURL");

    foreach($programs as $program) {
        echo "<li><a href='xml.php?u=" . $program . "'>" . $program . "</a></li>\n";
    }
}
function loadHodexProgram($loc) {
    $doc = loadXml($loc);
    
    if (getCountry($doc) == "nl")
    {
        $pd = getElementByTagName($doc, "programDescriptions");
        $names = $pd->getElementsByTagName("programName");
        
        foreach($names as $program) {
            if($program->attributes->getNamedItem("lang")->nodeValue == "nl")
               echo $program->nodeValue;
        }
    }
}

function getCountry($xmlDoc) {
    $pc = getElementByTagName($xmlDoc, "programClassification");
    return getElementByTagName($pc, "orgUnitCountry")->nodeValue;
}

function getElementByTagName($xmlDoc, $name) {
    return $xmlDoc->getElementsByTagName($name)->item(0);
}

function loadSubHodexIndex($loc, $container, $url) {
    $doc = loadXml($loc);
    
    $items = $doc->getElementsByTagName($container);
    $urls = array();
    
    for($i = 0; $i < $items->length; $i++) {
        $item = $items->item($i);
        $urlElement = getElementByTagName($item, $url);
        $urls[$i] = $urlElement->nodeValue;
    }
    return $urls;
}
function loadXml($loc) {
    $doc = new DOMDocument();
    $doc->load($loc);
    return $doc;
}

if (count($_GET) == 1) {
    $loc = $_GET["u"];
    loadHodexProgram($loc);
} else {
    $loc = "http://www.hodex.nl/hodexDirectory.xml";
    echo "<ul>\n";
    loadHodexIndex($loc);
    echo "</ul>";
    echo $programCount;
}

?>