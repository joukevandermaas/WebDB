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
    
    $result = array();
    
    if (getCountry($doc) == "nl")
    {
        $pd = getElementByTagName($doc, "programDescriptions");
        $names = $pd->getElementsByTagName("programName");

        $result["name"] = getElementInLang($names, "nl")->nodeValue;
        $result["courses"] = loadHodexCourses(getElementByTagName($doc, "programCurriculum"));
    }
    
    return $result;
}

function loadHodexCourses($xml) {
    $courses = $xml->getElementsByTagName("course");
    $result = array();
    
    for ($i = 0; $i < $courses->length; $i++)
    {
        $course = $courses->item($i);
        $courseObj = array();
        
        $courseObj["name"] = getElementInLang($course->getElementsByTagName("courseName"), "nl")->nodeValue;
        $courseObj["year"] = getElementByTagName($course, "yearOfCurriculum")->nodeValue;
        $courseObj["description"] = getElementInLang($course->getElementsByTagName("courseDescription"), "nl")->nodeValue;
        
        $result[$i] = $courseObj;
    }
    
    return $result;
}

function getElementInLang($elements, $lang) {
    foreach($elements as $element) {
        if($element->attributes->getNamedItem("lang")->nodeValue == $lang)
            return $element;
    }
    return $elements->item(0);
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

function displayCourses($courses, $year) {
    echo "<h2>Vakken jaar ".$year."</h2>\n";
    echo "<dl>\n";
    foreach($courses as $course) {
        if ($course["year"] == $year)
        {
            echo "<dt>".$course["name"]."</dt>\n";
            echo "<dd>".$course["description"]."</dd>\n";
        }
    }
    echo "</dl>";
}

if (count($_GET) == 1) {
    $loc = $_GET["u"];
    $program = loadHodexProgram($loc);
    
    echo "<h1>".$program["name"]."</h1>\n";
    
    displayCourses($program["courses"], 1);
    displayCourses($program["courses"], 2);
    displayCourses($program["courses"], 3);
    
} else {
    $loc = "http://www.hodex.nl/hodexDirectory.xml";
    echo "<ul>\n";
    loadHodexIndex($loc);
    echo "</ul>";
    echo $programCount;
}

?>