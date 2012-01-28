<?php
require_once('tools/cas.php');
$service = 0;

if (array_key_exists("logout", $_GET)) {
    logout($service);
}   
if (array_key_exists("ticket", $_GET)) {
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
}

?>
