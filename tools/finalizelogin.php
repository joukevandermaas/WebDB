<?php
// this page exists to make login.php simpler

include('helperfuncs.php');
// get some params from $_GET in a safe way
$service = getUsrParam('service', 0);
$ticket = getUsrParam('ticket', '');

session_start();
$_SESSION['ticket'] = $ticket; // write the ticket and service in
$_SESSION['service'] = $service; // a session temporarily

header("Location: ../login.php"); // redirect back to the login page

?>
