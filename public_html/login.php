<?php
require_once('tools/cas.php');

if (array_key_exists("logout", $_GET)) {
    logout(0);
}   
if (array_key_exists("ticket", $_GET)) {
   session_start();
   $_SESSION['ticket'] = getUsrParam('ticket', '');
   $_SESSION['loginservice'] = 0;
   
} else {
    getLoginTicket(0);
}

?>
