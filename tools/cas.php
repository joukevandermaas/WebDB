<?php
include_once('settings.php');
$casHosts = array (0 => 'https://bt-lap.ic.uva.nl/cas/');
$serverUrl = 'https://'.$_SERVER['SERVER_NAME'].Dir.'/tools/finalizelogin.php';
function logout($service) {
    global $serverUrl;
    global $casHosts;
    
    redirect($casHosts[$service]."logout");
}
function login($service) {
    global $casHosts;
    global $serverUrl;
    
    $redirUrl = getUrl($serverUrl, array('s' => $service));
    $url = getUrl($casHosts[$service]."login", array("service" => $redirUrl));
    redirect($url);
}
function getUserName($ticket, $service) {
    global $serverUrl;
    global $casHosts;
    
    $redirUrl = getUrl($serverUrl, array('s' => $service));
    $casUrl = getUrl($casHosts[$service]."serviceValidate", array("ticket" => $ticket, "service" => $redirUrl));

    return parseCasXml($casUrl);
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
    //echo $xml->saveXML();
    $succes = $xml->getElementsByTagName("authenticationSuccess")->length > 0;
    $user = null;
    if ($succes) {
        $user = $xml->getElementsByTagName("user")->item(0)->nodeValue;
    }
    return $user;
}

?>
