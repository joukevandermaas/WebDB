<?php

/*
Voor het krijgen van een lijst van onderwijsinstellingen, gebruik de volgende functie:
array loadHodexIndex($loc)
 - $loc: de locatie van de centrale hodex index (http://www.hodex.nl/hodexDirectory.xml)
 
Dit geeft een array terug met de volgende layout:
array(
    0 => array(
        "url" => <de url van de hodex-index van de onderwijsinstelling>,
        "orgUnitId" => <een id voor de onderwijsinstelling>
        ),
    ...
)


****************
Voor het verkrijgen van een lijst van studies, gebruik de volgende functie:
array loadHodexSchool($loc)
 - $loc: de locatie van de hodex-index van de school (te verkrijgen via loadHodexIndex)
 
Dit geeft een array terug met de volgende layout:
array(
    0 => array(
        "url" => <de url van de hodex-index van de studie>,
        "orgUnitId" => <een id voor de onderwijsinstelling>,
        "programId" => <een id voor de studie>
        ),
    ...
)


****************
Voor het verkrijgen van informatie over een studie, gebruik de volgende functie:
array loadHodexProgram($loc)
 - $loc: de locatie van het hodex-bestand met de informatie.

Dit geeft een array terug met de volgende layout (uitleg staat tussen < en >):

array(
    "croho" => <croho-code opleiding (zelfde voor verschillende instellingen)>
    "name" => <naam van de opleiding>,
    "summary" => <korte beschrijving>,
    "description" => <aanvulling op summary>,
    "organization" => <naam onderwijsinstelling>,
    "country" => <land onderwijsinstelling>,
    "admissionRequirements" =>
        array(
            <profiel> => array() <benodigde extra vakken (of lege array)>
        ),
    "degree" => <titel bij afsluiten>,
    "financing" => <financieëring (goverment of private)>,
    "numerusFixus" => <numerus fixus (0 indien geen nf)>,
    "credits" => <aantal studiepunten>,
    "duration" => <duur van de studie in maanden>,
    "level" => <niveau van de opleiding>,
    "contentLinks" => <extra informatie (filmpjes, verhalen, links, etc)
        array(
            0 => 
                array(
                    "subject" => <onderwerp>
                    "summary" => <korte beschrijving>,
                    "description" => <uitbreiding op summary>,
                    "type" => <type content>,
                    "url" => <adres van de link (of leeg)>
                ),
            ...
        ),
    "url" => <link naar vak op website onderwijsinstelling>,
    "courses" => 
        array(
            0 =>
                array(
                    "name" => <naam van het vak>,
                    "description" => <beschrijving van het vak>,
                    "type" => <type vak>,
                    "credits" => <aantal studiepunten>,
                    "examKind" => <type afsluiting>,
                    "curriculum" => <is het vak deel van het curriculum>,
                    "year" => <het studiejaar waarin dit vak wordt gegeven>
                ),
            ...
        )
)


*/




$prefLang = "nl";

function loadHodexIndex($loc) {
    return loadSubHodexIndex($loc, "hodexEntity", array("url" => "hodexDirectoryURL", "orgId" => "orgUnitId"));
}
function loadHodexSchool($loc) {
    return loadSubHodexIndex($loc, "hodexResource", array("url" => "hodexResourceURL", "orgId" => "orgUnitId", "programId" => "programId"));
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

function loadSubHodexIndex($loc, $container, $info) {
    $doc = loadXml($loc);
    
    $items = $doc->getElementsByTagName($container);
    $objects = array();
    $i = 0;
    
    foreach ($items as $item) {
        $object = array();
        foreach ($info as $key => $value)
            $object[$key] = getElementValue($item, $value, false);
        $objects[$i++] = $object;
    }
    return $objects;
}
function loadXml($loc) {
    $doc = new DOMDocument(1.0, "UTF-8");
    $doc->load($loc);
    return $doc;
}
?>













