<?php
session_start();
require_once 'dbconnect.php';

if (isset($_POST['saveform']) ) {
 $mid=$_SESSION['movieId'];
 $mname=$_POST['mname'];
 $myear=$_POST['myear'];
 $mtime=$_POST['mtime'];
 $mdir= $_POST['mdir'];
 $mcast=$_POST['mcast'];
 $mrate=$_POST['mrate'];
 $mdesp=$_POST['mdesp'];
 $mgenre=$_POST['mgenre'];

if (empty($mname) || empty($myear) || empty($mtime) || empty($mdir) || empty($mcast) || empty($mrate) || empty($mdesp) || empty($mgenre)){
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
	$query = "UPDATE moviedetails SET movieName='$mname', movieYear='$myear', movieTime='$mtime', movieDesp='$mdesp', movieDirect='$mdir', movieCast='$mcast', movieRate='$mrate', genreId='$genreid', movieImageName='$imageName', movieImage='$imageData' WHERE movieId='$mid'";
	$res = mysql_query($query);
	if($res){
			echo "<script type='text/javascript'>alert('Movie Updated Successfully');</script>";
		} else {
			echo "<script type='text/javascript'>alert('Error Again');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Only Images are Allowed');</script>";
}
}
if(isset($_POST['remove'])){
	
	if($_POST['mname'] == ""){
		echo "<script type='text/javascript'>alert('Please Select A Movie');</script>";
	} else {
		$mname=$_POST['mname'];
		$res=mysql_query("DELETE FROM moviedetails WHERE movieName='$mname'");
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

    <link rel="stylesheet" href="editmovie.css">
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
						$query = mysql_query("SELECT movieName FROM moviedetails");
						echo '<select align="center" style=" margin-left: 130px; font-size: 35px; border-radius: 5px; color: #E5C500; font-family: Yanone Kaffeesatz; width: 350;" id="moviename" name="mname">';
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
				<a href="addmovie.php">Add Movies</a>
				<a href="#" data-toggle="modal" data-target="#myModalRM">Remove Movies</a>
				<a href="#">Change Password</a>
				<a href="logout.php?logout">Sign Out</a>
			</div>
		</div>
	</div>
<h2 id="heading" style="color: #E5C500; font-size: 40px; font-family: Yanone Kaffeesatz;"><b>Edit Movies</b></h2>
<div id="dropmovie">
<?php
		$query = mysql_query("SELECT movieName FROM moviedetails");
		echo '<select style="margin-left:550px; margin-top:120px; font-size: 20px; color: #000000; font-family: Yanone Kaffeesatz; width: 320;" id="moviename" name="mname" onChange="showUser(this.value)">';
		echo '<option value="">Select a Movie:</option>';
		while ($row = mysql_fetch_array($query)) {
			echo '<option value="'.$row['movieName'].'">'.$row['movieName'].'</option>';
		}
		echo '</select>';// Close your drop down box
?>
</div>
<div id="txtHint"><b>Info will be listed here...</b></div>
</div>
<div id="footer">
            <p id="footpara" style="font-size: 20px; font-family: Lobster;"><b>Copyright &copy; 1990-2016. All Rights Reserved</b></p>
            <div class="social" id="around">
                <p style="font-size: 20px; font-family: Lobster; color: black;"><b>Around The Web</b></p>
                <ul style="margin-left: -45px; margin-top: -10px;">
                    <li><a href="#"><i class="fa fa-lg fa-linkedin"></i></a></li>
                    <li><a href="#"><i class="fa fa-lg fa-github"></i></a></li>
                    <li><a href="#"><i class="fa fa-lg fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-lg fa-facebook"></i></a></li>
                </ul>
            </div>
        </div>
</body>
</html>
<script>
function showUser(str) {
    if (str == "") {
		alert("Error");
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","editmovie.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>