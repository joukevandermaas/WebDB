<?php
session_start();
include('tools/helperfuncs.php');

$ticket = getUsrParam('ticket', '', $_SESSION);
$service = getUsrParam('loginservice', 0, $_SESSION);

$username = isLoggedIn($ticket, $service)
if($username) {
    $fn = getUsrParam('fn', '');
    $ln = getUsrParam('ln', '');
    if ($fn === '' && $ln === '') {
        $pageName = 'Registreren';
        $path = array ('Home' => 'index.php');
        include('header.php');
        echo "<p>Voer je gegevens in om te registreren:</p>"
        echo "<form action='register.php' method='get'>\n";
        echo "Voornaam: <input type='text' id='fn' /><br />\n";
        echo "Achternaam: <input type='text' id='ln' /><br />\n";
        echo "<input type='submit' value='Registreren' />\n";
        echo "</div></body></html>";
    } else {
        $query = "INSERT INTO users ".
            "(loginname, loginservice, firstname, lastname) VALUES ".
            "($userName, $service, $fn, $ln)";
        $result = mysql_query($query);
        if (!$result) die("Invalid query");
    }
}

?>