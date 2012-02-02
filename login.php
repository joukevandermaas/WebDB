<?php
session_start();
require_once('tools/cas.php');
include_once('tools/helperfuncs.php');
$defaultService = 0;

$ticket = getUsrParam('ticket', '', $_SESSION);
$service = getUsrParam('service', 0, $_SESSION);

if (isset($_GET['logout'])) {
    session_destroy();
    logout($service);
    exit();
}
if ($ticket === '')
    login($defaultService); 

$username = getUserName($ticket, $service);

$query = "SELECT * FROM users WHERE loginname='$username' && loginservice=$service";
$result = mysql_query($query, $dbcon);
if (!$result) {
    logout($service);
    die("You could not be logged in.");
}
$exists = mysql_num_rows($result) > 0;
session_unset();

$path = array('Home' => 'index.php');
if ($exists) {
    $loggedInUser = mysql_fetch_assoc($result);
    $_SESSION['user'] = $loggedInUser['id'];

    $pageName = 'Login';
    include('header.php');
    echo '<p>Je bent nu ingelogd.</p>';
    echo '</div></body></html>';
} else {
    $pageName = 'Registreren';
    include('header.php');

    echo '<p>Vul de gegevens in om je te registreren.</p>';
    echo "<form action='register.php' method='get'>\n";
    echo "Voornaam: <input type='text' id='firstname' name='firstname' /><br />\n";
    echo "Achternaam: <input type='text' id='lastname' name='lastname' /><br />\n";
    echo "<input type='hidden' value='$username' name='username' />";
    echo "<input type='hidden' value='$service' name='service' />";
    echo "<input type='submit' value='Registreren' />\n";
    echo "</div></body></html>";        
}
?>
