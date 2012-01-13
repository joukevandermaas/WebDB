<?php require("hodex.php") ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
     
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<?php

function print_s($tag, $content, $before = "", $after = "") {
    if (!empty($content)) {
        echo "<$tag>$before$content$after</$tag>";
    }
}
function renderProgram($loc) {
    $program = loadHodexProgram($loc);

    if ($program == null)
        return false;
    if ($program["country"] != "nl")
        return false;
    $level = $program["level"];
    if ($level != "academic master")
        if ($level != "academic bachelor")
            return false;
    
    echo "<a href='".$loc."'>Oorspronkelijke Hodex xml</a>\n";
    
    print_s("h1", $program["name"], "<a href='".$program["url"]."'>", "</a>");
    echo "<h2>Introductie</h2>";
    print_s("p", $program["summary"].$program["description"]);
    echo "<ul>\n";
    print_s("li", $program["degree"], "<strong>Titel:</strong> ");
    print_s("li", $program["financing"], "<strong>Financi&euml;ring:</strong>");
    print_s("li", $program["numerusFixus"], "<strong>Numerus fixus:</strong>");
    print_s("li", $program["credits"], "<strong>Studiepunten:</strong>");
    print_s("li", $program["duration"], "<strong>Duur:</strong>", " maanden");
    echo "</ul>\n";
    
    renderCourses($program["courses"]);
    renderContentLinks($program["contentLinks"]);
    
    return true;
}
function renderCourses($courses) {
    $topYear = getTopYear($courses);
    for($i = 1; $i <= $topYear; $i++) {
        echo "<h2>Vakken jaar $i</h2>";
        echo "<table><tr><th>Vak</th><th>Beschrijving</th></tr>\n";
        foreach($courses as $course) {
            if ($course["year"] == $i)
                echo "<tr><td>".$course["name"]."</td><td>".$course["description"]."</td></tr>";
        }
        echo "</table>";
    }
    
   
   
}
function renderYearTable($year, $courses) {
    echo "<h2>Vakken jaar $i</h2>";
        echo "<table><tr><th>Vak</th><th>Beschrijving</th></tr>\n";
        foreach($courses as $course) {
            if ($course["year"] == $year)
                echo "<tr><td>".$course["name"]."</td><td>".$course["description"]."</td></tr>";
        }
        echo "</table>";
}
function getTopYear($courses) {
    $top = 0;
    foreach ($courses as $course) {
        if ($course["year"] > $top) {
            $top = $course["year"];
        }
    }
    return $top;
}

function renderList() {
    $loc = "http://www.hodex.nl/hodexDirectory.xml";
    echo "<pre>\n";
    print_r(loadHodexIndex($loc));
    echo "</pre>";
}

if (count($_GET) == 1) {
    $loc = $_GET["u"];
    if (!renderProgram($loc))
        ;//renderList();
} else {
    renderList();
}

?></body></html>