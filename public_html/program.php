<?php
include_once 'tools/helperfuncs.php';
// include_once 'tools/posts.php';
require_once 'tools/connectdb.php'; 
include_once 'tools/loadprogram.php';

?>

<?php
$pageName = $program["name"];
$path = array ("Home" => "index.php", "Opleidingen" => "programlist.php?level=".$program['level']);
include("header.php"); 
?>

<?php
echo "<div class='opleidingPlaatje'><img src='http://www.historyking.com/images/Future-Of-Nanotechnology-Artificial-Intelligence.jpg' class='opleidingPlaatje'></div>";

echo "<h4>Introductie</h4>";

// dit is de xml informatie over de studie

echo "<p class='intro'>"
.$program['summary'].
"<br />
<br />
<a href='programinfo.php?id=".$program['id']."'>Meer studieinformatie</a>
</p>";


echo "<h4>Posts</h4>";
// de 5 best beoordeelde of meest recente gedeelde dingen
//echo "<ul class='posts'>";


?>

<script type="text/javascript">
loadContent(<?php echo $program['id']; ?>, 0, 'post');
</script>
<ul id="posts"></ul>

<script type="text/javascript" src="scripts/writePost.js"></script>
<?php
$user_id = 7;
echo "<div class='tekstbox'><div id='show'>
	<form id='ajax' method='POST' action=''>
	<INPUT type='BUTTON' value='plaats' ONCLICK='submitForm(".$program['id'].", ".$user_id.")'>
<br />Titel: <input type='text' id='title' size='32' value=''>
<br /><textarea id='text' cols='60' rows='15'></textarea>
</form>
</div></div>";

?>

<!-- link naar de 'archief' pagina met meer gedeelde content -->
<p><a href="archief.html">klik voor meer</a></p>
</div></body>
</html>
