<?php
session_start();
// Error reporting:
error_reporting(E_ALL^E_NOTICE);

include "connect.php";
include "comment.class.php";
$userid= $_SESSION['user'];
$res=mysql_query("SELECT user_name FROM userdetails WHERE userId='$userid'");
$row=mysql_fetch_array($res);
$uname=$row['user_name'];



/*
/	Select all the comments and populate the $comments array with objects
*/
global $link;
$comments = array();
$result = mysql_query("SELECT * FROM commentdetails ORDER BY commentID ASC");

while($row = mysql_fetch_assoc($result))
{
	$comments[] = new Comment($row);
}

?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>XOR MOVIES</title>

<link rel="stylesheet" type="text/css" href="styles.css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="script.js"></script>

</head>

<body>



<h1>COMMENT HERE :</h1>


<div id="main">

<?php

foreach($comments as $c){
	echo $c->markup();
}

?>

<div id="addCommentContainer">
	<p>Add a Comment</p>
	<form id="addCommentForm" method="post" action="">
    	<div>
        	<label for="name">Username :</label>
			<?php echo $uname; ?>
        <br>
            <label for="body">Comment Here :</label>
            <textarea name="body" id="body" cols="20" rows="5"></textarea>
            
            <input type="submit" id="submit" value="Submit" />
        </div>
    </form>
</div>

</div>



</body>
</html>
