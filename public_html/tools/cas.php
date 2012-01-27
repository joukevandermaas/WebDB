<?php
$casHosts = array (0 => 'https://bt-lap.ic.uva.nl/cas/');
$serverUrl = "http://websec.science.uva.nl/webdb1237/login.php";
function logout($service) {
    global $serverUrl;
    global $casHosts;

    redirect(getUrl($casHosts[$service]."logout", array ("service" => $serverUrl)));
}
function getLoginTicket($service) {
    global $serverUrl;
    global $casHosts;

    redirect(getUrl($casHosts[$service]."login", array( "service" => $serverUrl)));
}
function getUserName($ticket, $service) {
    global $serverUrl;
    global $casHosts;
    
    $xmlRequestUrl = getUrl($casHosts[$service]."serviceValidate", 
        array("ticket" => $ticket,
            "service" => $serverUrl));

    return parseCasXml($xmlRequestUrl);
}
function getUrl($url, $params) {
    $result = $url."?";
    
    foreach($params as $key => $value) {
        $result .= $key."=".urlencode($value)."&";
    }
    
    return rtrim($result, "&");
}
function redirect($url) {
    header("Location: $url");
}
function parseCasXml($loc) {
    $xml = new DOMDocument();
    $xml->load($loc);
    $succes = $xml->getElementsByTagName("authenticationSuccess") != null;
    $user = null;
    if ($succes != null) {
        $user = $xml->getElementsByTagName("user")->item(0)->nodeValue;
    }
    return $user;
}

?>
