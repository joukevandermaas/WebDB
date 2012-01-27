<?php
require("../tools/connectdb.php");

$postNo = 200;

mysql_query(
    "INSERT INTO users (id, loginname, loginservice, firstname, lastname, registertimestamp) ".
    "VALUES ".
    "(NULL, '1111', 0, 'Jouke', '', NULL), ".
    "(NULL, '1112', 0, 'Dilay', '', NULL), ".
    "(NULL, '1113', 0, 'Thomas', '', NULL), ".
    "(NULL, '1114', 0, 'Riar', '', NULL), ".
    "(NULL, '1115', 0, 'Sanira', '', NULL)", $dbcon);

$text = "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam feugiat adipiscing erat vitae egestas. Nullam eget dui eros, rhoncus imperdiet tellus. Mauris tincidunt velit in est placerat ut dapibus lorem viverra. In eu metus eget ipsum consequat elementum. Duis sed mauris ut orci molestie feugiat et eu metus. Integer quam mauris, malesuada at accumsan id, blandit sed lorem. Donec quis ultrices neque. Integer ut nunc ipsum. Ut sagittis ante ac lectus tristique adipiscing. Pellentesque venenatis nibh nec lectus sagittis varius. Vestibulum scelerisque, sapien id vehicula rutrum, tortor tortor molestie libero, vel laoreet quam lectus eget nisl. Sed in lectus mi, quis condimentum ante. Etiam egestas placerat orci eget malesuada. Sed ante tellus, auctor suscipit volutpat quis, consequat sodales eros. Nam venenatis pulvinar auctor. Nullam egestas neque leo.</p><p>Proin vitae neque nulla, at pulvinar arcu. Curabitur blandit, lorem ut eleifend venenatis, diam elit aliquet libero, vitae iaculis arcu ligula in velit. Pellentesque lobortis pretium rutrum. Nam justo tellus, aliquet et adipiscing sit amet, vestibulum posuere nunc. Morbi fringilla bibendum nunc, in tristique diam elementum vitae. Sed commodo justo sed lorem feugiat sollicitudin vel a sapien. Nunc eros neque, aliquet laoreet elementum pulvinar, adipiscing quis justo. Proin erat enim, elementum id ullamcorper ut, mollis et ligula. Etiam volutpat vestibulum tortor, sit amet sollicitudin massa volutpat in. Ut accumsan tempus nulla sit amet convallis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc imperdiet lobortis ultricies. Maecenas dapibus nulla sit amet arcu porttitor pellentesque. Sed faucibus enim et nunc mattis suscipit. Quisque quis facilisis diam.</p>";
    
$query = "INSERT INTO posts (id, program_id, user_id, title, content, timestamp, score) VALUES\n";
for($i = 0; $i < $postNo; $i++) {
    $pid = rand(1, 3078);
    $score = rand(-5, 50);
    $user = rand(1, 5);
    
    $query .= "(NULL, $pid, $user, 'Lorum ipsum', '$text', NULL, $score),\n";
}
$query = rtrim($query, "\n,");

mysql_query($query, $dbcon);

$text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras dignissim massa quis dolor aliquam tincidunt. Pellentesque eros justo, convallis vitae consectetur et, faucibus hendrerit mi. Vivamus mollis dictum odio, sed.";
$query = "INSERT INTO comments (id, post_id, user_id, content, timestamp) VALUES\n";
for($i = 0; $i < $postNo; $i++) {
    $pid = rand(1, $postNo);
    $user = rand(1, 5);
    
    $query .= "(NULL, $pid, $user, '$text', NULL),\n";
}
$query = rtrim($query, "\n,");

mysql_query($query, $dbcon);

header("Location: configdb.php?done");
?>