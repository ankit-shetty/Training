<?php
session_start();
require_once 'dbconnect.php';

if (isset($_POST['saveform']) ) {
	
 $mname=$_POST['mname'];
 $myear=$_POST['myear'];
 $mtime=$_POST['mtime'];
 $mdir= $_POST['mdir'];
 $mcast=$_POST['mcast'];
 $mrate=$_POST['mrate'];
 $mdesp=$_POST['mdesp'];
 $mgenre=$_POST['mgenre'];
 $movielink =$_POST['mlink'];

if (empty($mname) || empty($myear) || empty($mtime) || empty($mdir) || empty($mcast) || empty($mrate) || empty($mdesp) || empty($mgenre) || empty($movielink)){
        echo "<script type='text/javascript'>alert('Please Enter All The Details');</script>";
    }
$res1=mysql_query("SELECT genreId FROM genredetails WHERE genreName='$mgenre'");
if($res1){
	$row1=mysql_fetch_array($res1);
	$genreid=$row1['genreId'];
} else {
	echo "<script type='text/javascript'>alert('Error');</script>";
}
$imageName=mysql_real_escape_string($_FILES['image']['name']);
$imageData=mysql_real_escape_string(file_get_contents($_FILES['image']['tmp_name']));
$imageType=mysql_real_escape_string($_FILES['image']['type']);
if(substr($imageType,0,5)== "image"){
	$query = mysql_query("INSERT INTO moviedetails(movieName, movieYear, movieTime, movieDesp, movieDirect, movieCast, movieRate, genreId, movieImageName, movieImage, movieLink)  VALUES('$mname','$myear','$mtime','$mdesp','$mdir','$mcast','$mrate','$genreid','$imageName','$imageData', '$movielink')");
} else {
	echo "<script type='text/javascript'>alert('Only Images are Allowed');</script>";
}
}
if(isset($_POST['remove'])){
	
	if($_POST['mname'] == ""){
		echo "<script type='text/javascript'>alert('Please Select A Movie');</script>";
	} else {
		$mname=$_POST['mname'];
		if($res){
			echo "<script type='text/javascript'>alert('Movie Removed Successfully');</script>";
		} else {
			echo "<script type='text/javascript'>alert('Error Again');</script>";
		}
	}
}
if( isset($_POST['changepass'])){
	if(empty($_POST['oldpass']) || empty($_POST['newpass']) || empty($_POST['cpass'])){
		echo "<script type='text/javascript'>alert('Please Enter All The Fields');</script>";
		exit;
	} else {
		$oldpass=$_POST['oldpass'];
		$newpass=$_POST['newpass'];
		$cpass=$_POST['cpass'];
		$res=mysql_query("SELECT user_password FROM userdetails WHERE userId='1'");
		$row=mysql_fetch_array($res);
		if($oldpass != $row['user_password']){
			echo "<script type='text/javascript'>alert('Enter Correct Password');</script>";
		} else {
			if(strlen($newpass) < 6 || strlen($cpass) < 6){
				echo "<script type='text/javascript'>alert('Password Must Have Atleast 6 Characters');</script>";
			} else {
				if($newpass != $cpass){
					echo "<script type='text/javascript'>alert('Password Does Not Match');</script>";
				} else {
					$query = "UPDATE userdetails SET user_password='$newpass' WHERE userId='1'";
					$res = mysql_query($query);
					if($res){
						echo "<script type='text/javascript'>alert('Password Updated Successfully');</script>";
					} else {
						echo "<script type='text/javascript'>alert('Error Updating Password');</script>";
					}
				}
			}
		}
	}
}
?>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="addmovieF.css">
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
<div id="myModalRM" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000000;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center" style="font-size: 35px; color: #E5C500; font-family: Yanone Kaffeesatz;"><b>Remove Movies</b></h4>
            </div>
            <div class="modal-body" style="background-color: #000000;">
                <form method="POST" action="<?php $_PHP_SELF ?>">
					<?php
						session_start();
						require_once 'dbconnect.php';
						$query = mysql_query("SELECT movieName FROM moviedetails");
						echo '<select align="center" style=" margin-left: 130px; font-size: 35px; border-radius: 5px; color: #000000; font-family: Yanone Kaffeesatz; width: 350;" id="moviename" name="mname">';
						echo '<option value="">Select a Movie:</option>';
						while ($row = mysql_fetch_array($query)) {
							echo '<option value="'.$row['movieName'].'">'.$row['movieName'].'</option>';
						}
						echo '</select>';// Close your drop down box
					?>
                    <input align="center" style="border-radius: 5px; color: #000; margin-left: 220px; background-color: #E5C500; padding: 10px 10px; margin-top: 100px; font-family: Yanone Kaffeesatz; font-size: 25px;"type="submit" name="remove" class="remove removemodal-submit" value="Remove Movie">
                </form>
            </div>
            <div class="modal-footer" style="background-color: #000000;">
                <button type="button" style="font-size: 20px; background-color: #E5C500; color: #000000; font-family: Yanone Kaffeesatz;"class="btn btn-default" data-dismiss="modal"><b>Close</b></button>
            </div>
        </div>

    </div>
</div>
<div id="myModalCP" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000000;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center" style="font-size: 30px; color: #E5C500; font-family: Yanone Kaffeesatz;"><b>Change Password</b></h4>
            </div>
            <div class="modal-body" style="background-color: #000000;">
                <form method="post" action="<?php $_PHP_SELF ?>">
                    <input style="height: 45px; font-size: 16px;width: 50%;margin-bottom: 10px; background: whitesmoke;margin-left: 130px;border: 1px solid #d9d9d9;border-top: 1px solid #c0c0c0;padding: 0 8px;" type="password" name="oldpass" placeholder="Old Password">
                    <input style="height: 45px; font-size: 16px;width: 50%;margin-bottom: 10px; background: whitesmoke;margin-left: 130px;border: 1px solid #d9d9d9;border-top: 1px solid #c0c0c0;padding: 0 8px;" type="password" name="newpass" placeholder="New Password (min 6 characters)">
                    <input style="height: 45px; font-size: 16px;width: 50%;margin-bottom: 10px; background: whitesmoke;margin-left: 130px;border: 1px solid #d9d9d9;border-top: 1px solid #c0c0c0;padding: 0 8px;" type="password" name="cpass" placeholder="Confirm Password">
                    <input style="border: 0px;color: #000;background-color: #E5C500;padding: 10px 0px;margin-top: 20px;font-family: Yanone Kaffeesatz;font-size: 25px;width: 50%;display: block;margin-bottom: 10px;margin-left: 130px;position: relative;"type="submit" name="changepass" class="change changemodal-submit" value="Submit">
                </form>
            </div>
            <div class="modal-footer" style="background-color: #000000;">
                <button type="button" style="font-size: 20px; background-color: #E5C500; color: #000000; font-family: Yanone Kaffeesatz;" class="btn btn-default" data-dismiss="modal"><b>Close</b></button>
            </div>
        </div>

    </div>
</div>
<div id="mainbodyadd">
    <div id="header">
        <img class="mainimage" src="camxor.png">
        <h2 id="para1"><b>Xoriant<br>Movies</b></h2>
		<div class="dropdown" style="font-size: 25px; font-family: Yanone Kaffeesatz;">
			<button class="dropbtn"><span class="glyphicon glyphicon-user"></span> Admin Options<span class="glyphicon glyphicon-menu-down"></span></button>
			<div class="dropdown-content">
				<a href="adminpage.php">Home</a>
				<a href="editmovies.php">Edit Movies</a>
				<a href="#" data-toggle="modal" data-target="#myModalRM">Remove Movies</a>
				<a href="#">Change Password</a>
				<a href="logout.php?logout">Sign Out</a>
			</div>
		</div>
	</div>
	<br>
</div>
<h2 id="heading" style="color: #E5C500; font-size: 40px; font-family: Yanone Kaffeesatz;"><b>Add Movies</b></h2>


	<div id="maincontent" style=" margin-left:50px; margin-right:50px; margin-top:150px; padding-top :2px;">
		<form  action="<?php $_PHP_SELF ?>" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<input class="form-control input-lg" id="name_movie" name="mname" type="text" placeholder="Movie Name">
					</div>
					
					<div class="form-group">
						<input class="form-control input-lg" id="year_movie" type="text" name="myear" placeholder="Movie Year">
					</div>
					
					<div class="form-group">
						<input class="form-control input-lg" id="time_movie" type="text" name="mtime" placeholder="Movie Time In Minutes">
					</div>
					<div class="form-group" style = "padding-top : 8px;">
						<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
						<input class="form-control input-lg" id="upload_movie" type="file" name="image">
					</div>
				</div>
				<div class="col-md-4">
					
					<div class="form-group">
						<input class="form-control input-lg" id="movie_dir" type="text" name="mdir" placeholder="Movie Director">
					</div>
					
					<div class="form-group">
						<input class="form-control input-lg" id="movie_cast" type="text" name="mcast" placeholder="Movie Cast">
					</div>
					
					<div class="form-group">
						<input class="form-control input-lg" id="rate_movie" type="text" name="mrate" placeholder="Movie Rating">
					</div>
					
					<div class="form-group">
						<input class="form-control input-lg" id="link_movie" type="text" name="mlink" placeholder="Youtube Video Id">
					</div>
				</div>
			
				<div class="col-md-4" style="color:white;padding-top : 8px;">
					<textarea class="form-control input-lg" id="desp_movie"  rows="4.5" col="200" type="text" name="mdesp" placeholder="Enter Description"></textarea>
					<br>
					<div class="form-group" style = "padding-top : 16px;" >
						<select class="form-control input-lg" id="genre_drop" name="mgenre" style="color: #000000; font-size: 20px; font-family: Yanone Kaffeesatz;">
							<option value="Action">Action</option>
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
					</div>

				</div>
			</div>
			<center> <button class="btn btn-default" type="submit" name="saveform" style="font-size:25px; background-color: #E5C500; border : 2px solid black; color: black; font-family: Yanone Kaffeesatz;">Save Details</button></center>
		</form>





</div>
<div id="footer" style = "height : 100px;">
            <p id="footpara" style="font-size: 20px; font-family: Lobster;"><b><br>Copyright &copy; 1990-2016. All Rights Reserved</b></p>
            <div class="social" id="around">
                <p style="font-size: 20px; margin-left:100px; margin-top: -15px; font-family: Lobster; color: black;"><b><br>Around The Web</b></p>
                
                <ul style="margin-left: 60px; margin-top: -20px;">
                    <li><a href="#"><i class="fa fa-lg fa-linkedin"></i></a></li>
                    <li><a href="#"><i class="fa fa-lg fa-github"></i></a></li>
                    <li><a href="#"><i class="fa fa-lg fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-lg fa-facebook"></i></a></li>
                </ul>
            </div>
        </div>
</body>
</html>