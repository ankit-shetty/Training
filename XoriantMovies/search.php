<?php
	session_start();
	require_once 'dbconnect.php';
    $key=$_GET['key'];
    $array = array();
    $query=mysql_query("SELECT movieName FROM moviedetails WHERE movieName LIKE '%{$key}%'");
    while($row=mysql_fetch_assoc($query))
    {
      $array[] = $row['movieName'];
    }
    echo json_encode($array);
?>