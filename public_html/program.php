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

echo "<p class='intro'>".$program['summary'];

echo "<a href='programinfo.php?id=".$program['id']."'>Meer studieinformatie</a></p>";

?>

<script type="text/javascript">
loadContent(<?php echo $program['id']; ?>, 0, 'post');
</script>
<h4>Posts</h4>
<ul id="posts"></ul>

<script type="text/javascript" src="scripts/writePost.js"></script>
<div id='newpost'>
	<form method='POST' action='' onsubmit='submitPost(<?php echo $program['id']; ?>)'>
        <span>Deel een verhaal, afbeelding of video:</span>
        <table>
            <tr><td>Titel:</td><td><input type='text' id='title' size='32' value=''></td><td></td></tr>
            <tr><td></td><td><textarea id='text' cols='60' rows='15'></textarea></td><td><input type='submit' value='Plaats' /></td></tr>
        </table>
        
        
        
    </form>
</div>

<!-- link naar de 'archief' pagina met meer gedeelde content -->
<p><a href="archief.html">klik voor meer</a></p>
</div></body>
</html>
