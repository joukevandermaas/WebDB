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

    //foreach($programs as $program) {
        echo "<li><a href='hodex.php?u=" . $programs[0] . "'>" . $programs[0] . "</a></li>\n";
    //}
}
function loadHodexProgram($loc) {
    $doc = loadXml($loc);
    
    $result = array();
    
    if (getCountry($doc) == "nl")
    {
        $pd = getElementByTagName($doc, "programDescriptions");
        $names = $pd->getElementsByTagName("programName");

        $result["url"] = $loc;
        $result["name"] = getElementInLang($names, "nl")->nodeValue;
        
        $curriculum = getElementByTagName($doc, "programCurriculum");
        $result["courses"] = loadRegularHodexCourses($curriculum);
    }
    
    return $result;
}

function loadHodexCourses($xml) {
    $courses = $xml->getElementsByTagName("course");
    $result = array();
    
    for ($i = 0; $i < $courses->length; $i++)
    {
        $course = $courses->item($i);
        $courseObj = loadHodexCourse($course);       
        $result[$i] = $courseObj;
    }
    
    return $result;
}

function loadHodexCourse($course) {
    $courseObj = array();
        
    $courseObj["name"] = getElementInLang($course->getElementsByTagName("courseName"), "nl")->nodeValue;
    
    $yearElem = getElementByTagName($course, "yearOfCurriculum");
    $descElem = $course->getElementsByTagName("courseDescription");
    $typeElem = getCourseType($course);
    
    if ($yearElem != null)
        $courseObj["year"] = $yearElem->nodeValue;
    else
        $courseObj["year"] = 1;
    
    if ($descElem->length > 0)
        $courseObj["description"] = getElementInLang($descElem, "nl")->nodeValue;
    else
        $courseObj["description"] = "Geen beschrijving beschikbaar.";
    
    $courseObj["type"] = $typeElem->nodeValue;
    
    return $courseObj;
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

function getCourseType($course) {
    $type = getElementByTagName($course, "courseType");
    if ($type != null)
        return $type->nodeValue;
    else
        return "regular";
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
    echo "<table><tr><th>Vak</th><th>Type</th><th>beschrijving</th>\n";
        
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
    echo "<a href='".$program["url"]."'>Oorsprong</a>\n";
    
    displayCourses($program["courses"], 1);
    displayCourses($program["courses"], 2);
    displayCourses($program["courses"], 3);
    
} else {
    $loc = "http://www.hodex.nl/hodexDirectory.xml";
    echo "<ul>\n";
    loadHodexIndex($loc);
    echo "</ul>";
}

?>