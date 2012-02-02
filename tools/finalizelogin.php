<?php

include('helperfuncs.php');

$service = getUsrParam('service', 0);
$ticket = getUsrParam('ticket', '');

session_start();
$_SESSION['ticket'] = $ticket;
$_SESSION['service'] = $service; 

header("Location: ../login.php");

?>
