<?php
require_once "functions.php";

function get_all_movies()
{
	$sql = "SELECT * from moviedetails ORDER BY movieId DESC ";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) > 0)
		{
		//echo " all fetched";
	} else {
		echo "0 rows . failed .";
	}
	return $result;
}
?>