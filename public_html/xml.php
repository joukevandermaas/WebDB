<?php

function loadHodexIndex($loc) {
    $schools = loadSubHodexIndex($loc, "hodexEntity", "hodexDirectoryURL");
    
    foreach($schools as $school) {
        loadHodexSchool($school);
    }
}
function loadHodexSchool($loc) {
    $degrees = loadSubHodexIndex($loc, "hodexResource", "hodexResourceURL");
    
    foreach($degrees as $degree) {
        loadHodexDegree($degree);
    }
}
function loadHodexDegree($loc) {
    
}

function loadSubHodexIndex($loc, $container, $url) {
    $doc = loadXml($loc);
    
    $items = $doc->getElementsByTagName($container);
    $urls = array();
    
    for($i = 0; $i < sizeof($items); $i++) {\
        $item = $items[$i];
        $urlElement = $item->getElementByTagName($url);
        $urls[$i] = $urlElement->item(0)->nodeValue;
    }
    return $urls;
}
function loadXml($loc) {
    $doc = new DOMDocument();
    $doc->load($loc);
    return $doc;
}

$loc = "http://www.hodex.nl/hodexDirectory.xml";
loadHodexIndex($loc);

?>