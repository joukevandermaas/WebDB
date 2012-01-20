<?php
$serverUrl = "http://websec.science.uva.nl/~jvdm/login.php";
$casService = "https://bt-lap.ic.uva.nl/cas/";

function logout() {
    global $casService;

    redirect(getUrl($casService."logout", array ("service" => $serverUrl));
}
function getLoginTicket() {
    global $casService;
    global $serverUrl;

    redirect(getUrl($casService."login"), array( "service" => $serverUrl));
}
function getUserName($ticket) {
    global $casService;
    global $serverUrl;
    $xmlRequestUrl = getUrl($casService."serviceValidate", 
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

if (array_key_exists("logout", $_GET)) {
    logout();
}
if (array_key_exists("ticket", $_GET)) {
    
} else {
    getLoginTicket();
}

?>
</body>
</html>
