<?php
    include('header.php');
    $id = isset($_GET['id']) ? mysql_real_escape_string($_GET['id']) : 0;

    if (!$id){
        header("Location: programlist.php");
        exit();
    }
    $query = "SELECT * FROM programs WHERE id=$id";
    $result = mysql_query($query, $dbcon);

    if(!$result) die("Invalid id: $id");

    $program = mysql_fetch_assoc($result);
    $hodexurl = $program['hodexurl'];

    include('hodex.php');

    $info = loadHodexProgram($hodexurl);

    $query = "SELECT programs.name, orgs.name ".
             "FROM programs JOIN orgs ON orgs.id=programs.org_id".
             "WHERE croho=".$program['croho'];
    $result = mysql_query($query, $dbcon);

    $others = array();
    if($result){
         $i = 0;
         while($row = mysql_fetch_assoc($result)){
            $others[$i++] = $row;
        }
    }

    echo "<h2>".$program['name']."</h2>\n";
    echo "<h4>Beschrijving</h4>\n";
    echo "<p class='intro'>".$info['summary']." ".$info['description']."</p>";
    if (!empty($others)) {
        echo "<ul>";
        foreach($others as $x);
            echo "<li>$x</li>";
        echo "</ul>";
    }
?>
