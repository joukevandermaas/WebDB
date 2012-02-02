<?php
include_once('settings.php');
require('cas.php');
require('connectdb.php');

$websiteName = WebsiteName;

// escape sql and html code from anything users could've touched
function getUsrParam($name, $default, $array = 0) {
    if (!$array) // use $_GET by default
        $array = $_GET;
    if (isset($array[$name]))
        return mysql_real_escape_string(htmlspecialchars($array[$name]));
    return $default;
}
function getShortString($string, $maxLength) { // shortens long strings
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
    //fetches all results from a query in one go
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

// indents lines (used for generating Json)
function getIndent($count) {
    $spacesPerLevel = 4;
    $result = '';
    for ($i = 0; $i < ($count * $spacesPerLevel); $i++)
        $result .= ' ';
    return $result;
}
// creates an array of json objects from a set of php arrays
function getJsonArray($array, $quoteStrings = true, $indent = 0, $cLimit = 0) { 
    $jsonOutput = getIndent($indent)."[\n";
    foreach($array as $item) {
        $jsonOutput .= getJsonObject($item, $quoteStrings, $indent + 1, $cLimit).",\n";
    }
    $jsonOutput = rtrim($jsonOutput, "\n,"); // remove last comma
    $jsonOutput .= "\n".getIndent($indent)."]";
    return $jsonOutput;
}
// generates a json object from an array
function getJsonObject($item, $quoteStrings = true, $indent = 0, $cLimit = 0) {
    $jsonOutput = getIndent($indent)."{\n";
    foreach($item as $key => $value) {
        $valueString = '';
        if (is_string($value)) { // strings are enclosed in double quotes
            $valueString = $quoteStrings 
                ? '"'.str_replace('"', '\"', getShortString($value,$cLimit)).'"'
                : getShortString($value, $cLimit);
        } elseif(is_bool($value)) { 
            // php converts false to an empty string by default,
            // but javascript expects true or false
            $valueString = $value ? 'true' : 'false';
        } else { // for anything else, php conversion will do
            $valueString = (string)$value;
        }
        $jsonOutput .= getIndent($indent + 1).'"'.$key.'": '.$valueString.','."\n";
    }
    $jsonOutput = rtrim($jsonOutput, "\n,");
    $jsonOutput .= "\n".getIndent($indent)."}";
    return $jsonOutput;
}

function getUserInfo($id) {
    global $dbcon;
    $query = "SELECT * FROM users WHERE id=$id LIMIT 1";

    $result = mysql_query($query, $dbcon);
    $user = $result ? mysql_fetch_assoc($result) : die('Invalid id');
    return $user;
}

function getPostType($url, &$link) {
    $type = 'text'; // assume it's text
    $link = '';
    $urlParts = parse_url($url);
    if (strpos($urlParts['host'], 'youtu')) { // catches youtube.com and youtu.be
        $type = 'video';
        $vid = explode('&', $urlParts['query']); // we only want the video ID, not anything else
        $link = substr($vid[0], 2); // remove v=
    } elseif(isset($urlParts['path'])) {
        $file = pathinfo($urlParts['path']);
        if ($file['extension'] == 'png' || // check for image extensions,
            $file['extension'] == 'jpg' || // because loading the image and checking the
            $file['extension'] == 'gif') { // content-type is too slow
            
            $type = 'image';
            $link = $url;
        }
    }
    return $type;
}

?>
