<?php
include_once('settings.php');
// currently, only one cas host is supported
$casHosts = array (0 => DefaultCasHost);
// the redir url for when login was succesfull
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
    
    // get the ticket from the cas host
    $redirUrl = getUrl($serverUrl, array('s' => $service));
    $casUrl = getUrl($casHosts[$service]."serviceValidate", array("ticket" => $ticket, "service" => $redirUrl));

    // parse it's xml
    return parseCasXml($casUrl);
}
function getUrl($url, $params) {
    //returns a url with all the parameters escaped
    
    $result = $url."?";
    
    foreach($params as $key => $value) {
        $result .= $key."=".urlencode($value)."&";
    }
    
    return rtrim($result, "&"); // remove the last &
}
function redirect($url) {
    header("Location: $url");
}
function parseCasXml($loc) {
    $xml = new DOMDocument();
    $xml->load($loc);
    // if <authenticationSuccess> doesn't exist, the login failed
    $succes = $xml->getElementsByTagName("authenticationSuccess")->length > 0;
    
    $user = null;
    if ($succes) {
        $user = $xml->getElementsByTagName("user")->item(0)->nodeValue;
    }
    return $user;
}

?>
