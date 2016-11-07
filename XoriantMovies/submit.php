<?php

// Error reporting:
error_reporting(E_ALL^E_NOTICE);
session_start();
include "connect.php";
include "comment.class.php";


global $movieid;
$movieid =$_SESSION["mid"]=$_GET["movieid"];
$res = mysql_query("SELECT * FROM moviedetails WHERE movieid='$movieId'");
$row = mysql_fetch_array($res);


/*
/	This array is going to be populated with either
/	the data that was sent to the script, or the
/	error messages.
/*/

$arr = array();
$validates = Comment::validate($arr);

if($validates)
{
	/* Everything is OK, insert to database: */
	$movieid=$_GET['movieid'];
	$res=mysql_query("SELECT * FROM moviedetails WHERE movieid='$movieId'");
	$row=mysql_fetch_assoc($res);
	mysql_query("	INSERT INTO commentdetails(name,body,movieid)
					VALUES (
						'".$arr['name']."',
						'".$arr['body']."',
						'".$row['movieid']."'
					)");
					
	/*
	/	The data in $arr is escaped for the mysql query,
	/	but we need the unescaped variables, so we apply,
	/	stripslashes to all the elements in the array:
	/*/
	
	$arr = array_map('stripslashes',$arr);
	
	$insertedComment = new Comment($arr);

	/* Outputting the markup of the just-inserted comment: */

	echo json_encode(array('status'=>1,'html'=>$insertedComment->markup()));

}
else
{
	/* Outputtng the error messages */
	echo '{"status":0,"errors":'.json_encode($arr).'}';
}

?>