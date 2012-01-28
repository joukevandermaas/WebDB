
<html><body>
<?php
require 'connectdb.php';

$addtodb = true;

if(isset($_GET["id"])){
	$p_id = htmlspecialchars($_GET["id"]);
} else {
	$addtodb = false;
	echo "no program <br />";
}
if(isset($_GET["user"])){
	$u_id = htmlspecialchars($_GET["user"]);
} else {
	$addtodb = false;
	echo "no user <br />";
}

if(isset($_POST["title"])){
	$title = htmlspecialchars($_POST["title"]);
	if($title == ''){
		$addtodb = false;
		echo "no title <br />";
	}
} else {
	$addtodb = false;
	echo "no title <br />";
}

if(isset($_POST["text"])){
	$text = htmlspecialchars($_POST["text"]);
	if($text == ''){
		$addtodb = false;
		echo "no text <br />";
	}
} else {
	$addtodb = false;
	echo "no text <br />";
}

if($addtodb){
	$query = "INSERT INTO posts (id, program_id, user_id, title, content, timestamp, score) VALUES (null, $p_id, $u_id, '".$title."', '".$text."', null, 0)";
	$result = mysql_query($query);
} else {
	echo "you post has not been added <br />";
}
echo $title;
echo $text;

?>
</body></html>