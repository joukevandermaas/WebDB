<?php
require_once('tools/cas.php');
include_once('tools/helperfuncs.php');
$service = 0;

print_r($_GET);
/*
if (isset($_GET['logout'])) {
    logout($service);
}   
if (isset($_GET['ticket'])) {
    session_start();
    $ticket = getUsrParam('ticket', '');
    $_SESSION['ticket'] = $ticket;
    $_SESSION['loginservice'] = $service;
    $username = getUserName($ticket, $service);
    
    $query = "SELECT * FROM users WHERE loginname='$username' && loginservice=$service";
    $result = mysql_query($query);
    if (!$result) {
        logout($service);
        die("You could not be logged in.");
    }
    $exists = mysql_num_rows($result) > 0;
    
    if(!$exists) {
        redirect('register.php');
    }
    
} else {
    getLoginTicket($service);
}*/

?>
