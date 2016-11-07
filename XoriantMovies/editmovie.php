<?php
session_start();
require_once 'dbconnect.php';

$movname = $_GET['q'];

$query = mysql_query("SELECT * FROM moviedetails WHERE movieName='$movname'");
$row = mysql_fetch_array($query);

$mid=$_SESSION['movieId']=$row['movieId'] ;
$mname=$_SESSION['movieName']=$movname;
$myear=$_SESSION['movieYear'] =$row['movieYear'] ;
$mtime=$_SESSION['movieTime']=$row['movieTime'] ;
$mdir=$_SESSION['movieDirect']=$row['movieDirect'] ;
$mcast=$_SESSION['movieCast']=$row['movieCast'] ;
$mrate=$_SESSION['movieRate']=$row['movieRate'] ;
$mdesp=$_SESSION['movieDesp']=$row['movieDesp'] ;
$mgenre=$_SESSION['genreId']=$row['genreId'] ;
$mipath=$_SESSION['movieImagepath']=$row['movieImagepath'] ;

$query = mysql_query("SELECT genreName FROM genredetails WHERE genreId='$mgenre'");
$row = mysql_fetch_array($query);
$mgenrename=$row['genreName'] ;
?>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="addmovie.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <title>Xoriant Movies</title>
</head>
<body>
<div id="mainbodyadd">
<div id="middlesec" style="width: 320; margin-top:50px; margin-left:-850px;">
<form  action="<?php $_PHP_SELF ?>" method="POST" enctype="multipart/form-data">
		<input id="middlename" style="font-size: 20px; color: #000000; font-family: Yanone Kaffeesatz;" style="font-size: 20px; font-family: Yanone Kaffeesatz;" type="text" name="mname" value="<?php echo $mname; ?>" placeholder="Movie Name">
        <input id="middleyear" style="font-size: 20px; color: #000000; font-family: Yanone Kaffeesatz;" type="text" name="myear" value="<?php echo $myear; ?>" placeholder="Movie Year">
        <input id="middletime" style="font-size: 20px;color: #000000; font-family: Yanone Kaffeesatz;" type="text" name="mtime" value="<?php echo $mtime; ?>" placeholder="Movie Time In Minutes">
        <input id="middledir" style="font-size: 20px; color: #000000; font-family: Yanone Kaffeesatz;" type="text" name="mdir" value="<?php echo $mdir; ?>" placeholder="Movie Director">
        <input id="middlecast" style="font-size: 20px;color: #000000; font-family: Yanone Kaffeesatz;" type="text" name="mcast" value="<?php echo $mcast; ?>" placeholder="Movie Cast">
        <input id="middlerate" style="font-size: 20px; color: #000000; font-family: Yanone Kaffeesatz;" type="text" name="mrate" value="<?php echo $mrate; ?>" placeholder="Movie Rating">
		<input id="middledesp" style="height: 145; margin-left:850px; font-size: 20px; color: #000000; font-family: Yanone Kaffeesatz;" value="<?php echo $mdesp; ?>" type="text" name="mdesp" placeholder="Movie Description">
		<select id="middlegenre" style="margin-top: 345px; margin-left:850px; width: 320; color: #000000; font-size: 20px; font-family: Yanone Kaffeesatz;"name="mgenre">
			<option value="<?php echo $mgenrename; ?>"><?php echo $mgenrename; ?></option>
			<option value="display">Action</option>
			<option value="Adventure">Adventure</option>
			<option value="Comedy">Comedy</option>
			<option value="Crime">Crime</option>
			<option value="Drama">Drama</option>
			<option value="Fantasy">Fantasy</option>
			<option value="Horror">Horror</option>
			<option value="Mystery">Mystery</option>
			<option value="Romance">Romance</option>
			<option value="ScienceFiction">Science Fiction</option>
			<option value="Thriller">Thriller</option>
		</select>
        <input id="middleupload" type="file" name="image" value="<?php echo $mipath; ?>">
		<button class="btn btn-default" type="submit" id="save" name="saveform" style="font-size:25px; background-color: #E5C500; color: black; font-family: Yanone Kaffeesatz;">Save Details</button>
</form>
</div>
</div>
</body>
</html>