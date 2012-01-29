
<?php
include_once('tools/helperfuncs.php');

$currentpostid = getUsrParam('id', 0);
$query = "SELECT posts.*, COUNT(comments.id) AS comment_count ".
    "FROM posts JOIN (comments, users) ".
    "ON (comments.post_id = posts.id) ".
    "WHERE posts.id=$currentpostid ".
    "LIMIT 1";

$result = mysql_query($query);
if (!$result) die('Invalid query '.$query);
$post = mysql_fetch_assoc($result);

    
$pageName = "Post";
$path = array(
    'Home' => 'index.php',
    'Opleiding' => 'program.php?id='.$post['program_id']
);

include('header.php');

$txt = $post['content'];

echo "<h4>".$post['title']."</h4>
<div class='intro'>".$post['content']."
<ul class='reacties'><li>comments: ".$post['comment_count']." </li> <li>user: ".$post['user_id']." </li> <li>time: ".$post['timestamp']."</li></ul>
</div>";
?>

<h4>Reacties</h4>
<ul id='comments'>
    <li id='newcomment'>
        <span>Plaats een reactie</span><span id='commentlength'></span><br />
        <form method='post' action='' onsubmit='submitComment(<?php echo $post['id']; ?>)'>
            <textarea id='text' onkeyup='checklength(this)'></textarea>
            <input type='submit' value='Plaatsen' />
        </form>
    </li>
</ul>

<script type="text/javascript">
loadContent(<?php echo $post['id']; ?>, 0, 'comment');
</script>
</div></body>
</html>
