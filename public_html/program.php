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

<?php

echo "<div id='show'>
	<form id='test' onsubmit='return false;'>
		<h3>Deel wat leuks door hier te typen</h3>
		Title: <input type='text' name='title' id='title' size='40'><br />
		<input type='text' name='text' id='text'  size='146'><br />
		<input type='submit' value='submit' onClick='sendRequest()'>
	</form>
</div>";

?>

<!-- link naar de 'archief' pagina met meer gedeelde content -->
<p><a href="archief.html">klik voor meer</a></p>
</div></body>
</html>
