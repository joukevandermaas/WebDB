<!--

Voor het verkrijgen van informatie over een studie, gebruik de volgende functie:

array loadHodexProgram($loc)

$loc: de locatie van het hodex-bestand met de informatie.

Dit geeft een array terug met de volgende layout (uitleg staat tussen < en >):

array(
    "name" => <naam van de opleiding>,
    "summary" => <korte beschrijving>,
    "description" => <aanvulling op summary>,
    "admissionRequirements" =>
        array(
            "profile" => <het benodigde profiel>,
            "additionalSubjects" => array(<benodigde extra vakken>)
        ),
    "applicationRequirements" => 
        array(
            <type> => <description>,
            ...
        )
    "degree" => <titel bij afsluiten>,
    "financing" => <financieëring (goverment of private)>,
    "numerusFixus" => <numerus fixus (0 indien geen nf)>,
    "credits" => <aantal studiepunten>,
    "duration" => <duur van de studie in maanden>,
    "level" => <academic bachelor/academic master>,
    "contentLinks" =>
        array(
            0 => 
                array(
                    "lang" => <taal van de link>,
                    "summary" => <korte beschrijving>,
                    "description" => <uitbreiding op summary>,
                    "type" => <type content>,
                    "url" => <adres van de link>
                ),
            ...
        ),
    "url" => <link naar vak op website onderwijsinstelling>,   
)

-->

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
    
    if (isInCountry($doc, "nl"))
    {
        $pd = getElementByTagName($doc, "programDescriptions");
        $names = $pd->getElementsByTagName("programName");
        
        $result = array(
            "name" => getElementValue($pd, "programName", true),
            "summary" => getElementValue($doc, "programSummary", true),
            "description" => getElementValue($doc, "programDescription", true),
            "degree" => getElementValue($doc, "programLevel", false),
            "financing" => getElementValue($doc, "financing", false),
            "numerusFixus" => getElementValue($doc, "numerusFixus", false),
            "credits" => getElementValue($doc, "programCredits", false),
        )
            
        
        //$curriculum = getElementByTagName($doc, "programCurriculum");
        //$result["courses"] = loadHodexCourses($curriculum);
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
    
    $nameElems = $course->getElementsByTagName("courseName");
    $yearElem = getElementByTagName($course, "yearOfCurriculum");
    $descElems = $course->getElementsByTagName("courseDescription");
    $type = getCourseType($course);
    
    if ($nameElems->length > 0)
        $courseObj["name"] = getElementInLang($nameElems)->nodeValue;
    else
        $courseObj["name"] = "";
    
    if ($yearElem != null)
        $courseObj["year"] = $yearElem->nodeValue;
    else
        $courseObj["year"] = 1;
    
    if ($descElems->length > 0)
        $courseObj["description"] = getElementInLang($descElems)->nodeValue;
    else
        $courseObj["description"] = "";
    
    $courseObj["type"] = $type;
    
    return $courseObj;
}

function getElementValue($element, $tagName, $multiLanguage)
{
    $values = $element->getElementsByTagName($tagName);
    if ($multiLanguage)
        return getElementInLang($values)->nodeValue;
    else
        return $values->item(0)->nodeValue;
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
    return $element->attributes->getNamedItem("lang")->nodeValue;
}

function isInCountry($xmlDoc, $lang) {
    $pc = getElementByTagName($xmlDoc, "programClassification");
    
    foreach($pc->getElementsByTagName("orgUnitCountry") as $country)
    {
        if ($country->nodeValue == $lang)
            return true;
    }
    return false;
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
    $doc = new DOMDocument(1.0, "UTF-8");
    $doc->load($loc);
    return $doc;
}

function displayCourses($courses, $year) {
    echo "<h2>Vakken jaar ".$year."</h2>\n";
    echo "<table><tr><th>Vak</th><th>beschrijving</th>\n";
        
    foreach($courses as $course) {
        if ($course["year"] == $year)
        {
            echo "<tr class='".$course["type"]."'>\n";
            echo "<td>".$course["name"]."</td>\n";
            echo "<td>".$course["description"]."</td>\n";
            echo "</tr>\n";
        }
    }
    echo "</table>";
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
    
    echo "<h1>".$program["name"]."</h1>\n";
    echo "<a href='".$loc."'>Oorspronkelijke Hodex xml</a>\n";
    
    echo "<p>".$program["summary"]."</p>\n";
    echo "<p>".$program["description"]."</p>\n";
    
    displayCourses($program["courses"], 1);
    displayCourses($program["courses"], 2);
    displayCourses($program["courses"], 3);
    
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