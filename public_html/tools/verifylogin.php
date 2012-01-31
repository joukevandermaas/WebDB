<?php

include('cas.php');
include('helperfuncs.php');

$redir = getUsrParam('r', '');
$service = getUsrParam('s', 0);
$ticket = getUsrParam('ticket', '');

if (isset($redir))
    redirect($redir."?login=1");

$xml = new DomDocument();
$xml->load(getUrl(
    $casHosts[$service].'serviceValidate',
    array('ticket' => $ticket,
          'service' => $serverUrl)));
echo $xml->saveXML();


?>
