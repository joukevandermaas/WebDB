<?php
$serverUrl = "http://websec.science.uva.nl/~jvdm/login.php";
$casService = "https://bt-lap.ic.uva.nl/cas/";


function logout() {
    global $casService;
    
    redirect($casService."logout?service=".$serverUrl);
}
function getLoginTicket() {
    global $casService;
    global $serverUrl;

    redirect($casService."login?service=".$serverUrl);
}
function getUserName($ticket) {
    global $casService;
    global $serverUrl;
    $xmlRequestUrl = $casService.'serviceValidate?ticket='.$ticket.'&service='.$serverUrl;
    echo $xmlRequestUrl;
    return parseCasXml($xmlRequestUrl);
}

function redirect($url) {
    echo '<script type="text/javascript">';
    echo 'window.location="'.$url.'"';
    echo '</script>';
}
function parseCasXml($loc) {
    // $xmlFile = get_file_contents($loc);
    $xml = new DOMDocument();
    $xml->load($loc);

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
if (array_key_exists("logout", $_GET)) {
    logout();
}
if (array_key_exists("ticket", $_GET)) {
    echo "<h1>".getUserName($_GET["ticket"])."</h1>";
} else {
    getLoginTicket();
}

?>
</body>
</html>
