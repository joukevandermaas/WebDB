<?php 
require("database.php");
$websiteName = "Naam van de website";
$connection = getConnection();

function getProgramName($id) {
    global $connection;
    $saveid = mysql_real_escape_string($id);
    $query = "SELECT name FROM programs WHERE id = $saveid LIMIT 1";
        
    $result = mysql_query($query, $connection);
    $name = mysql_fetch_row($result);
    if ($name)
        return $name[0];
}

/**************/

function getPageTitle() {
    global $websiteName;
    
    $title = "";
    if (array_key_exists("id", $_GET))
        $title .= getProgramName($_GET["id"])." | ";
    return $title.$websiteName;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="CSS.css">
<title><?php echo getPageTitle(); ?></title>
</head>

<body><div class="rand">
<h1><div class="logo">Straks de header</div></h1>

<ul id="topnav">
<li><a href="index.php">Home</a></li>
<li><a href="list.php?type=2">Bachelor</a></li>
<li><a href="list.php?type=3">Master</a></li>
<li><a href="organizations.php">Instellingen</a></li>
</ul>