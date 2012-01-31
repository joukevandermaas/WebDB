<?php 
if (!session_id() !== '') 
    session_start();
include_once("tools/helperfuncs.php");
require_once("tools/connectdb.php");

if (!isset($pageName))
    die('Set variable $pageName before including header.php');
if (!isset($path))
    die('Set variable $path before including header.php');

$title = $pageName." | ".$websiteName;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title><?php echo $title; ?></title>

<script type="text/javascript" src='scripts/contentlist.js'></script>
<script type="text/javascript" src="scripts/vote.js"></script>
<script type="text/javascript" src="scripts/writePost.js"></script>
<script type="text/javascript" src="scripts/submitcomment.js"></script>
</head>

<body><div class="rand">
<h1><div class="logo"><?php echo $websiteName; ?></div></h1>

<ul id="topnav">
<li><a href="index.php">Home</a></li>
<li><a href="programlist.php?level=3">Bachelor</a></li>
<li><a href="programlist.php?level=4">Master</a></li>
<li class="last"><a href="organizations.php">Opleidinginstellingen</a></li>
</ul>

<h2 class="title_grd"><?php echo $pageName; ?></h2>
<ul class="breadcrumbs">
<?php
foreach($path as $name => $url) {
    echo "<li><a href='$url'>$name</a></li>\n";
}   
echo "<li class='current'><a href='#'>$pageName</a></li>\n";
?>
</ul>
