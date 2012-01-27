<?php
// gebruik deze functie om de posts van een studie op te roepen
function commentsProgram($program){
	global $page;
	global $numberOfComments;
	$start = 0 + $numberOfComments*($page-1);
	
	$query="SELECT * FROM comments WHERE programs_id= $program";
$comments = mysql_query($query);	
	return $comments;
}

function getComments($comments, $i){
	$arr = array(
		
		'content' => mysql_result($comments, $i, 'content'),
		'time' => mysql_result($comments, $i, 'timestamp'),		
		'user_id' => mysql_result($comments, $i, 'user_id')
	);

	return $arr;
}

?>