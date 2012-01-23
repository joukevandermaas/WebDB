<?php
$database="test";

@mysql_select_db($database) or die("unable to select database");
$addtodatabase = true;

if($_POST["title"] == ""){
	$addtodatabase = false;
	echo "title is empty <br />";
} else 
	
if($_POST["text"] == ""){
	$addtodatabase = false;
	echo "text is empty <br />";
}

if($addtodatabase){
	$query="INSERT INTO posts SET programs_id='20', users_id='1', title='".$_POST['title']."', content='".$_POST['text']."', score='0', comment_count='0'";
	mysql_query($query);
	echo 'add to database';
}
	
mysql_close();
?>