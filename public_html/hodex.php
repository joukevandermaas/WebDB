<?php
$prefLang = "nl";

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
    
    $result = null;
    
    $pd = getElementByTagName($doc, "programDescriptions");
    $pc = getElementByTagName($doc, "programClassification");
    $cu = getElementByTagName($doc, "programCurriculum");
    
    $result = array(
        "croho" => getElementValue($pc, "crohoCode", false),
        "name" => getElementValue($pd, "programName", true),
        "summary" => getElementValue($pd, "programSummary", true),
        "description" => getElementValue($pd, "programDescription", true),
        "organization" => getElementValue($pc, "orgUnitName", false),
        "country" => getElementValue($pc, "orgUnitCountry", false),
        "admissionRequirements" => getAdmissionRequirements($pc),
        "degree" => getElementValue($pc, "programLevel", false),
        "financing" => getElementValue($pc, "financing", false),
        "numerusFixus" => getElementValue($pc, "numerusFixus", false),
        "credits" => getElementValue($pc, "programCredits", false),
        "duration" => getDurationInMonths($pc),
        "level" => getElementValue($pc,  "programLevel", false),
        "contentLinks" => getContentLinks($pd),
        "url" => getElementValue($pc, "webLink", true),
        "courses" => getCourses($cu)
    );

    return $result;
}

function getElementValue($element, $tagName, $multiLanguage)
{
    $values = $element->getElementsByTagName($tagName);
    $element = $multiLanguage ? getElementInLang($values) : $values->item(0);
    
    return $element == null ? "" : $element->nodeValue;
}
function getElementInLang($elements) {
    global $prefLang;
    foreach($elements as $element) {
        if(getLang($element) == $prefLang)
            return $element;
    }
    return $elements->item(0);
}
function getLang($element) {
    return getAttributeValue($element, "lang");
}
function getAttributeValue($element, $attribute) {
    $att = $element->attributes->getNamedItem($attribute);
    return $att == null ? "" : $att->nodeValue;
}

function getElementByTagName($xmlDoc, $name) {
    return $xmlDoc->getElementsByTagName($name)->item(0);
}

function getAdmissionRequirements($xml) {
    $programs = $xml->getElementsByTagName("admissableProgram");
    $requirements = array();

    foreach ($programs as $program) {
        $aSubjectElements = $program->getElementsByTagName("additionalSubject");
        $aSubjectNames = array();
        $i = 0;
        foreach ($aSubjectElements as $aSubject) {
            $aSubjectNames[$i++] = $aSubject->nodeValue;
        }
        $requirements[getElementValue($program, "profile", false)] = $aSubjectNames;
    }
    
    return $requirements;
}
function getDurationInMonths($xml) {
    $durationEl = getElementByTagName($xml, "programDuration");
    $durationUnit = getAttributeValue($durationEl, "unit");
    
    switch($durationUnit) {
        case "day":
            return 1;
        case "week":
            return 1;
        case "year":
            return $durationEl->nodeValue * 12;
        case "month":
        default:
            return $durationEl->nodeValue;
    }
}
function getContentLinks($xml) {
    $linkElements = $xml->getElementsByTagName("contentLink");
    
    $links = array();
    $i = 0;
    foreach ($linkElements as $elem) {
        $links[$i++] = getContentLink($elem);
    }
    return $links;
}
function getContentLink($xml) {
    return array(
        "subject" => getElementValue($xml, "subject", false),
        "summary" => getElementValue($xml, "contentSummary", true),
        "description" => getElementValue($xml, "contentDescription", true),
        "type" => getElementValue($xml, "contentType", false),
        "url" => getElementValue($xml, "webLink", false)
    );
}
function getCourses($xml) {
    $courseElems = $xml->getElementsByTagName("course");
    
    $courses = array();
    $i = 0;
    foreach($courseElems as $elem) {
        $courses[$i++] = getCourse($elem);
    }
    return $courses;
}
function getCourse($xml) {
    return array(
        "name" => getElementValue($xml, "courseName", true),
        "description" => getElementValue($xml, "courseDescription", true),
        "type" => getElementValue($xml, "courseType", false),
        "credits" => getElementValue($xml, "credits", false),
        "examKind" => getElementValue($xml, "examKind", false),
        "curriculum" => getElementValue($xml, "partOfCurriculum", false),
        "year" => getElementValue($xml, "yearOfCurriculum", false)
    );
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
    $doc = new DOMDocument(1.0, "UTF-8");
    $doc->load($loc);
    return $doc;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
     
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<?php

function renderProgram($loc) {
    $program = loadHodexProgram($loc);
    
    if ($program == null)
        return false;
    
    echo "<a href='".$loc."'>Oorspronkelijke Hodex xml</a>\n<pre>";
    print_r($program);
    echo "</pre>";
    
    return true;
}
function renderList() {
    $loc = "http://www.hodex.nl/hodexDirectory.xml";
    echo "<ul>\n";
    loadHodexIndex($loc);
    echo "</ul>";
}

if (count($_GET) == 1) {
    $loc = $_GET["u"];
    if (!renderProgram($loc))
        renderList();
} else {
    renderList();
}

?></body></html>