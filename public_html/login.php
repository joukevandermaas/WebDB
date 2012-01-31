<?php
session_start();
require_once('tools/cas.php');
include_once('tools/helperfuncs.php');
$service = 0;

if (isset($_GET['logout'])) {
    session_destroy();
    logout($service);
    exit();
}
if (!isset($_SESSION['loginservice'])) {
    if (!isset($_GET['login']))
        login($service, '../login.php'); 
    $_SESSION['loginservice'] = $service;
    $username = getUserName($service);
        
    $query = "SELECT * FROM users WHERE loginname='$username' && loginservice=$service";
    $result = mysql_query($query);
    if (!$result) {
        logout($service);
        die("You could not be logged in.");
    }
    $exists = mysql_num_rows($result) > 0;

    $path = array('Home' => 'index.php');
    if(!$exists) {
        $pageName = 'Registreren';
        include('header.php');

        echo '<p>Vul de gegevens in om je te registreren.</p>';
        echo "<form action='register.php' method='get'>\n";
        echo "Voornaam: <input type='text' id='firstname' name='firstname' /><br />\n";
        echo "Achternaam: <input type='text' id='lastname' name='lastname' /><br />\n";
        echo "<input type='submit' value='Registreren' />\n";
        echo "</div></body></html>";
        
    }
}
?>
