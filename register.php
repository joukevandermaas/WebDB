<?php
session_start();
require_once('tools/connectdb.php');
include('tools/helperfuncs.php');

$firstname = getUsrParam('firstname', '', $_GET);
$lastname = getUsrParam('lastname', '', $_GET);
$username = getUsrParam('username', '', $_GET);
$service = getUsrParam('service', '', $_GET);

$query = "INSERT INTO users (loginname, loginservice, firstname, lastname) VALUES ".
    "('$username', $service, '$firstname', '$lastname')";
$result = mysql_query($query, $dbcon);
if (!$result) exit();

$id = mysql_insert_id($dbcon);
$_SESSION['user'] = $id;

$pageName = 'Registreren';
$path = array('Home' => 'index.php');
include('header.php');

echo "<p>Je bent nu ingelogd.</p>";
echo "</div></body></html>";

?>
