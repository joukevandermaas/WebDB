<?php include("header.php");

function getStaticInfo($pid) {
    global $connection;
    $savepid = mysql_real_escape_string($pid);
    $query = "SELECT programs.name, orgs.name, programs.summary ".
             "FROM programs JOIN orgs ON programs.org_id = orgs.id ".
             "WHERE programs.id = $savepid";
    
    $result = mysql_query($query, $connection);
    $info = mysql_fetch_row($result);
    if ($info)
        return $info;
}
function getPosts($pid) {
    global $connection;
    $savepid = mysql_real_escape_string($pid);
    $query = "SELECT posts.content, users.firstname, users.lastname, posts.timestamp, COUNT(comments.id) ".
             "FROM posts JOIN (comments, users) ON (posts.id = comments.post_id AND users.id = posts.user_id) ".
             "WHERE posts.program_id = $savepid";
    
    $result = mysql_query($query, $connection);
    $posts = mysql_fetch_array($result);
    if ($posts)
        return $posts;
}

$info = getStaticInfo($_GET["id"]);
echo "<div class='title_grd'><h2>".$info[0]." (".$info[1].")</h2></div>";
?>
<ul class="breadcrumbs">
    <li><a href="index.php">Home</a></li>
    <li><a href="list.php?type=2">Bacheloropleidingen</a></li>
    <li class="current"><a href="#">Kunstmatige intelligentie</a></li>
</ul>

<h4>Introductie</h4>
<p class="intro">
    <?php 
        echo $info[2];
        echo " <a href='program_info.php?id=".$_GET["id"]."'>Meer info...</a>";
    ?>
</p>

<h4>Posts</h4>
<ul class="posts">
<li><ul class="thumbs"><li><img src="img/thumbsup.png"></li><li><img src="img/thumbsdown.png"></li></ul><h5></h5>

<pre><?php print_r(getPosts($_GET["id"])); ?></pre>
<ul class="reacties"><li>comments</li><li>Name</li><li>Date</li></ul>
</li>

</ul>

<h3>Deel iets!</h3>
<p class="txtField">
Txtfield voor een reactie.<br />
nog meer txtfield.
</p>

<!-- link naar de 'archief' pagina met meer gedeelde content -->
<p><a href="archief.html">klik voor meer</a></p>
</div></body>
</html>