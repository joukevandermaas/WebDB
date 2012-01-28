<?php
require('cas.php');
require('connectdb.php');

$websiteName = "Studiegids";
function getUsrParam($name, $default, $array = 0) {
    if (!$array)
        $array = $_GET;
    if (isset($array[$name]))
        return mysql_real_escape_string(htmlspecialchars($array[$name]));
    return $default;
}
function getShortString($string, $maxLength) {
    if ($maxLength < 1) return $string;
    if (strlen($string) > $maxLength) {
        return substr($string, 0, $maxLength - 3)."...";
    }
    return $string;
}
function getFriendlyLevel($level) {
    switch($level) {
        case '1':
            return "Bachelor (HBO)";
        case '2':
            return "Master (HBO)";
        case '3':
            return "Bachelor";
        case '4':
            return "Master";
    }
    return $level;
}

function getMysqlArray($response) {
    if (!$response) {
        return false;
    }
    $array = array();
    $i = 0;
    while ($row = mysql_fetch_assoc($response)) {
        $array[$i++] = $row;
    }
    return $array;
}
function getJson($mysqlArray, $cLimit) { 
    $jsonOutput = "[\n";
    foreach($mysqlArray as $item) {
        $jsonOutput .= "  {\n";
        foreach($item as $key => $value) {
            $jsonOutput .= '    "'.$key.'": "'.getShortString($value, $cLimit).'",'."\n";
        }
        $jsonOutput = rtrim($jsonOutput, "\n,");
        $jsonOutput .= "\n  },\n";
    }
    $jsonOutput = rtrim($jsonOutput, "\n,");
    $jsonOutput .= "\n]";
    return $jsonOutput;
}
function getUserInfo($ticket, $service) {
    global $dbcon;
    $user = DEBUG ? '1111' : getUserName($ticket, $service);
    $query = "SELECT * FROM users WHERE loginname='$user' && loginservice=$service LIMIT 1";

    $result = mysql_query($query, $dbcon);
    $user = $result ? mysql_fetch_assoc($result) : die('Invalid ticket');
    return $user;
}
function isLoggedIn($ticket, $service) {
    if (DEBUG) return true;
    $user = getUserName($ticket, $service);
    return $user != null ? $user : false;
}

?>
