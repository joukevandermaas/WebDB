<?php
require 'connectdb.php';
include 'helperfuncs.php';

class PostList {
    private $program;
    private $postsPerPage = 5;
    
    function __construct($program, $ppp = 5) {
        $this->program = $program;
        $this->postsPerPage = $ppp;
    }
    
    function getArray($page) {
        global $dbcon;
        $start = $page * $this->postsPerPage;
        $count = $this->postsPerPage;
        
        $query = "SELECT *, COUNT(comments.id) AS comment_count ".
            "FROM posts JOIN comments ON (comments.post_id=posts.id) ".
            "WHERE program_id=".$this->program." ".
            "ORDER BY posts.timestamp DESC, (1- (score/posts.timestamp)) ASC ".
            "LIMIT $start, $count";
        $result = mysql_query($query, $dbcon);
        if (!$result)
            return false;
        else 
            return $this->createArray($result);
    }
    private function createArray($mysqlResult) {
        $result = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($mysqlResult)) {
            $result[$i++] = $row;
        }
        return $result;
    }
}

$postsPerPage = 4;
$page = getUsrParam('page', 0);
$program = getUsrParam('id', 1394);

$postList = new PostList($program, $postsPerPage);
$posts = $postList->getArray($page);

$jsonOutput = "[\n";
foreach($posts as $post) {
    $jsonOutput .= "  {\n";
    foreach($post as $key => $value) {
        $jsonOutput .= '    "'.$key.'": "'.getShortString($value, 100).'",'."\n";
    }
    $jsonOutput = rtrim($jsonOutput, "\n,");
    $jsonOutput .= "\n  },\n";
}
$jsonOutput = rtrim($jsonOutput, "\n,");
$jsonOutput .= "\n]";

echo $jsonOutput;

/*

// met deze functie haal je op hoe veel pagina's er gemaakt moeten worden
function getNumberOfPages($studie){
	global $postsPerPage;
	
	$query= "SELECT * FROM posts WHERE programs_id=$studie";
	$posts = mysql_query($query);
	$aantal = mysql_numrows($posts);
	
	$number = ($aantal +($numberOfPosts -1) )/$numberOfPosts;

	return $number;
}

// deze fuctie zorgt voor de back en next link onder aan de posts
function backNext(){
	global $page;

	$nPage = $page + 1;
	$pPage = $page - 1;
	
	if($pPage >= 1){
		echo "<a href='?page=".$pPage."'>back</a> ";
	}
	if($nPage <= getNumberOfPages(20)){
		echo "<a href='?page=".$nPage."'>next</a>";
	}
}

// gebruik deze functie om de posts van een studie op te roepen
function postsProgram($program){
	global $page;
	global $numberOfPosts;
	$start = 0 + $numberOfPosts*($page-1);
	
	$query="SELECT * FROM posts WHERE program_id= $program LIMIT $start,$numberOfPosts";	
	return posts($query);
}

// gebruik deze functie om de posts van een gebruiker op te roepen
function postsUser($user){
	global $page;
	global $numberOfPosts;
	$start = 0 + $numberOfPosts*($page-1);
	
	$query="SELECT * FROM posts WHERE users_id = $user LIMIT $start,$numberOfPosts";	
	return posts($query);
}

// met de 2 bovenstaande functies genereerd dit de posts
function posts($query){
	
	$posts = mysql_query($query);
	$aantal = mysql_numrows($posts);
	
	//for($i = 0; $i < $aantal; $i++){
	//	printPost($posts, $i);
	//}
	
	return $posts;
}

// deze functie print de posts die bij de bovenstaande functie is gegenereerd
function printPost($posts, $i){
	$id = mysql_result($posts, $i, 'id');

	$query = "SELECT COUNT(id) FROM comments GROUP BY post_id HAVING post_id= $id";
	$result = MySql_query($query);
	$comments = (mysql_fetch_row($result));
	$comment_count = $comments[0];
	
	$title = mysql_result($posts, $i, 'title');
	$content = mysql_result($posts, $i, 'content'); 
	$time = mysql_result($posts, $i, 'timestamp');
	$score = mysql_result($posts, $i, 'score'); 
	//$comment_count = mysql_result($posts, $i, 'comment_count');
	$user_id = mysql_result($posts, $i, 'user_id');
		
	echo "<h3>" .$title. "</h3>" 
	.$content. 
	"<br /> time: ".$time. " score: " .$score. " comments: " .$comment_count. " user: " .$user_id. "<br /><br />";
}

function getPost($posts, $i){
	$id = mysql_result($posts, $i, 'id');

	$query = "SELECT COUNT(id) FROM comments GROUP BY post_id HAVING post_id= $id";
	$result = MySql_query($query);
	$count = MySql_fetch_row($result);
	
	$arr = array(
		'title' => mysql_result($posts, $i, 'title'),
		'content' => mysql_result($posts, $i, 'content'),
		'time' => mysql_result($posts, $i, 'timestamp'),
		'comment_count' => $count[0],
		'user_id' => mysql_result($posts, $i, 'user_id')
	);

	return $arr;
}
*/
?>
