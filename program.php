<?php
include_once 'tools/helperfuncs.php';
require_once 'tools/connectdb.php'; 
include_once 'tools/loadprogram.php';

?>

<?php
$pageName = $program["name"];
$path = array (
    "Home" => "index.php", 
    "Opleidingen" => "programlist.php?level=".$program['level'],
    $program['org_name'] => "programlist.php?id=".$program['org_id']
    );
include("header.php"); 
?>
<div class='margin'>
<?php
echo "<div class='opleidingPlaatje'><img src='http://www.historyking.com/images/Future-Of-Nanotechnology-Artificial-Intelligence.jpg' class='opleidingPlaatje'></div>";

echo "<h4>Introductie</h4>";

// the basics about a program are stored in the database for performance reasons

echo "<p class='intro'>".$program['summary']." ";

echo "<a href='programinfo.php?id=".$program['id']."'>Meer studieinformatie</a></p>";

?>
<!-- show the user posts using javascript -->
<script type="text/javascript">
loadContent(<?php echo $program['id']; ?>, 'post');
</script>
<h4>Posts</h4>
<ul id="posts"></ul>

<!-- Users can add their own posts. The form will be interpreted using javascript -->
<script type="text/javascript" src="scripts/writePost.js"></script>
<div id='newpost'>
	<form method='POST' action='' onsubmit='submitPost(<?php echo $program['id'].", 3"; ?>)'>
        <span>Deel een verhaal, afbeelding of video:</span>
        <table>
            <tr><td>Titel:</td><td><input type='text' id='title' size='32' value=''></td><td></td></tr>
            <tr><td></td><td><textarea id='text' cols='60' rows='15'></textarea></td><td><input type='submit' value='Plaats' /></td></tr>
        </table>
        
        
        
    </form>
</div>

<!-- Loads more posts in place -->
<p><a id='moar' href='#' onclick="loadContent(<?php echo $program['id']; ?>, 'post')">klik voor meer</a></p>
</div>
</div></body>
</html>
