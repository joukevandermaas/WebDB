<?php

// Error reporting:
error_reporting(E_ALL^E_NOTICE);

include "connect.php";
include "comment.class.php";


/*
/	Select all the comments and populate the $comments array with objects
*/

$comments = array();
//alles wordt van boven gesorteerd dus van boven naar beneden
$result = mysql_query("SELECT * FROM comments ORDER BY id ASC");

?>


<html>
<head>

<title>Simple I am awsome!</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
<div id="main">
<?php

/*
/	Output the comments one by one:
*/

foreach($comments as $c){
	echo $c->markup();
	//Each comment has a markup() method, which generates valid HTML code ready to be printed to the page. 
}

?>

<div id="addCommentContainer">
	<p>Add a Comment</p>
	<form id="addCommentForm"  action="">
    	<div>      
            <label for="body">Comment Body</label>
            <textarea name="body" id="body" cols="20" rows="15"></textarea>
            
            <input type="submit" id="submit" value="Submit" />
        </div>
    </form>
</div>

</div>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="script.js"></script>

</body>
</html>
