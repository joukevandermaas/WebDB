<?php
$pageName = "Instellingen";
$path = array("Home" => "index.php");

include("header.php");

echo "<div class='margin'>";
// GROUP BY org_id to make COUNT work
$query = "SELECT orgs.id, orgs.name, COUNT(programs.id) ".
    "FROM orgs JOIN programs ON orgs.id=programs.org_id ".
    "GROUP BY org_id ORDER BY orgs.name";
$result = mysql_query($query, $dbcon);
if(!$result) die ("Fout. ".$query);

while ($row = mysql_fetch_row($result))
{
    echo "<div class='orglink'><h4><a href='programlist.php?org=".$row[0]."'>".$row[1]."</a></h4>\n";
    echo "<p>".$row[2]." studies.</p></div>\n";
}
?>
</div>
</div></body></html>
