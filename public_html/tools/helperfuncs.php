<?php
$websiteName = "Studiegids";
function getUsrParam($name, $default, $array = 0) {
    if (!$array)
        $array = $_GET;
    if (isset($array[$name]))
        return mysql_real_escape_string(htmlspecialchars($array[$name]));
    return $default;
}
function getShortString($string, $maxLength) {
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

?>