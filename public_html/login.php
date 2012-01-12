<?php
$serverUrl = "http://websec.science.uva.nl/~jvdm/login.php";
$loginService = "https://bt-lap.ic.uva.nl/cas/login";
$ticketValidateService = "https://bt-lap.ic.uva.nl/cas/serviceValidate?ticket=";

function getLoginTicket() {
    global $loginService;
    global $serverUrl;

    echo '<script type="text/javascript">';
    echo 'window.location="'.$loginService.'?service='.$serverUrl.'"';
    echo '</script>';
}
function getUserName($ticket) {
    global $ticketValidateService;
    global $serverUrl;
    $xmlRequestUrl = $ticketValidateService.$ticket.$serverUrl;

    return parseCasXml($xmlRequestUrl);
}
function parseCasXml($loc) {
    $xml = new DOMDocument();
    $xml->load($xmlRequestUrl);
    $succes = $xml->getElementsByTagName("authenticationSuccess");
    $user = null;
    if ($succes != null) {
        $user = $succes->getElementsByTagName("user")->nodeValue;
    }
    return $user;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
<title>Login</title>
</head>
<body>
<?php
if (array_key_exists("ticket", $_GET)) {
    echo "<h1>".getUserName($_GET["ticket"])."</h1>";
} else {
    getLoginTicket();
}

?>
</body>
</html>