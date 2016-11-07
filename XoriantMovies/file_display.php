<?php
 error_reporting(E_ALL);
 // some basic sanity checks
 include_once 'dbconnect.php';
 if(isset($_GET['id']) && is_numeric($_GET['id'])) {

	$id=mysql_real_escape_string($_GET['id']);
     // get the image from the db
	// the result of the query
     $result = mysql_query("SELECT movieImage FROM moviedetails WHERE movieId='$id'") or die("Invalid query: " . mysql_error());
	 $row = mysql_fetch_assoc($result);
		$imageData=$row['movieImage'];
     // set the header for the image
     header("content-type: image/jpeg");
     echo $imageData;
 }
 else {
     echo 'Please use a real id number';
 }
?>