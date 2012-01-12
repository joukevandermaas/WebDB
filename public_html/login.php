<?php

$serverUrl = "http://websec.science.uva.nl/~jvdm/login.php";
$loginService = "https://bt-lap.ic.uva.nl/cas/login";
$ticketValidateService = "https://bt-lap.ic.uva.nl/cas/serviceValidate?ticket=";

function getLoginTicket() {
    global $loginService;
    global $serverUrl;

    http_redirect($loginService, array("service" => $serverUrl);
}
function getUserName($ticket) {
    global $ticketValidateService;
    global $serverUrl;
    $xmlRequestUrl = $ticketValidateService.$ticket.$serverUrl;

    return parseCasXml($xmlRequestUrl);
}
function parseCasXml($loc) {
    DOMDocument xml = new DOMDocument();
    xml->load($xmlRequestUrl);
    $succes = xml->getElementsByTagName("authenticationSuccess");
    $user = null;
    if ($succes != null) {
        $user = $succes->getElementsByTagName("user")->nodeValue;
    }
    return $user;
}

if (array_key_exists("ticket", $_GET); {
    echo "<h1>".getUserName($_GET["ticket"])"</h1>";
} else {
    getLoginTicket();
}

?>
