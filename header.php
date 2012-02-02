<?php 
// this might be called when a session is already open
// (it might not, though)
if (session_id() == '') 
    session_start();

// ensure we're always on https for security reasons
if (!isset($_SERVER['HTTPS'])|| !$_SERVER['HTTPS']){
	$url = 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'] ;
	header('location: '.$url, true, 301) ;
}

include_once("tools/helperfuncs.php");
require_once("tools/connectdb.php");

// other pages have to set the title and breadcrumbs-path
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

<!-- always load all javascript to make things easier (if a little bit slower) -->
<script type="text/javascript" src='scripts/contentlist.js'></script>
<script type="text/javascript" src="scripts/vote.js"></script>
<script type="text/javascript" src="scripts/writePost.js"></script>
<script type="text/javascript" src="scripts/submitcomment.js"></script>
</head>

<body><div class="rand">
<h1><div class="logo"><?php echo $websiteName; ?></div></h1>
<div class='login'>
<?php 

// print login/logout link depending on current status
$userId = getUsrParam('user', 0, $_SESSION);
if($userId === 0){
	echo "<a href='login.php'>Inloggen</a>";
} else {
	echo "<a href='login.php?logout'>Uitloggen</a>";
}
?>
</div>

<ul id="topnav">
<li><a href="index.php">Home</a></li>
<li><a href="programlist.php?level=3">Bachelor</a></li>
<li><a href="programlist.php?level=4">Master</a></li>
<li class="last"><a href="organizations.php">Opleidingsinstellingen</a></li>
</ul>

<h2 class="title_grd"><?php echo $pageName; ?></h2>
<ul class="breadcrumbs">
<?php
// print the breadcrumbs
foreach($path as $name => $url) {
    echo "<li><a href='$url'>$name</a></li>\n";
}   
echo "<li class='current'><a href='#'>$pageName</a></li>\n";
?>
</ul>
