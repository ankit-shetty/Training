<?php
session_start();
if( !isset($_SESSION['user'])){
    header("Location: mainpage.php");
}
require_once 'dbconnect.php';

$userid= $_SESSION['user'];
$res=mysql_query("SELECT user_name FROM userdetails WHERE userId='$userid'");
$row=mysql_fetch_array($res);
$uname=$row['user_name'];
if( isset($_POST['changepass'])){
	if(empty($_POST['oldpass']) || empty($_POST['newpass']) || empty($_POST['cpass'])){
		echo "<script type='text/javascript'>alert('Please Enter All The Fields');</script>";
		exit;
	} else {
		$oldpass=$_POST['oldpass'];
		$newpass=$_POST['newpass'];
		$cpass=$_POST['cpass'];
		$res=mysql_query("SELECT user_password FROM userdetails WHERE user_name='$uname'");
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
					$query = "UPDATE userdetails SET user_password='$newpass' WHERE user_name='$uname'";
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
<?php
session_start();
require_once 'dbconnect.php';

if(isset($_POST['viewmore'])){
    if ( isset($_SESSION['user'])!="" ){
        $imgid=$_SESSION['mid'];
    header("Location: movie_content.php?movieid=$imgid");
}
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="usercss.css">
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
<div id="mainbody">
    <div id="header">
        <img class="mainimage" src="camxor.png">
        <h2 id="para1"><b>Xoriant<br>Movies</b></h2>
        <div class="dropdown" style="font-size: 20px; font-family: Yanone Kaffeesatz;">
			<button class="dropbtn"><span class="glyphicon glyphicon-user"></span> Hi, <?php echo $row['user_name']; ?> <span class="glyphicon glyphicon-menu-down"></span></button>
			<div class="dropdown-content">
				<a href="#" data-toggle="modal" data-target="#myModalCP">Change Password</a>
				<a href="logout.php?logout">Sign Out</a>
			</div>
		</div>
    </div>
	<div id="section1">
        <div id="img">
            <img class="image1" src="assignxor.jpg">
        </div>
        <div id="img2">
            <img class="xorcam" src="yellowcam.png">
        </div>
        <h2 id="welcome"><b>Welcome To Xoriant Movies</b></h2>
        <div class="container-1">
            <input class="form-control" type="search" id="search" placeholder="Search..." />
        </div>
        <div id="downarrow">
            <a href="#section2"><input type="image" class="imagearr" src="downarrow.png"></a>
        </div>
    </div>
    <div id="section2">
        <h1 style="font-size: 50px; font-family: Lobster;color: #E5C100;">Most Watched Movies</h1>
        <br><br><br><br><br><br>
        <?php
        include 'dbconnect.php' ;
        include 'functions.php';
        $movie_set = get_all_movies();
    ?>
    <div class="row">
        <?php 
            session_start();
            while($row = mysql_fetch_array($movie_set)){
                $imgid=$row["movieId"];
                $image=$row["movieImage"];
                
                //echo "<script type='text/javascript'>alert('$imgid');</script>";
        
        ?>
        <div class="col-md-3" style="margin-left:80px;">
          <div class="thumbnail" style="overflow:hidden;" id="autogrid">
          <img src='file_display.php?id=<?php echo $imgid; ?>' style=" border: 2px solid #E5C500; height: 300px; width:200px; margin-top:5px; overflow:hidden;" id="autogridimg" alt="..." />
            <div class="caption">
              <h3 style="font-size: 30px;margin-top:3px;font-family: Yanone Kaffeesatz;"><b><?php echo $row["movieName"]; ?></b></h3>
              <p style="font-size: 20px;font-family: Yanone Kaffeesatz;"><?php echo $row["movieYear"]; ?> | <?php echo $row["movieTime"]; ?> min</p>
              <a role="button" align="center" style="font-size: 20px; background-color: #E5C500; font-family: Yanone Kaffeesatz; border-radius:5px; border: 1px solid #000000;margin-left:70px; width:50%" href="movie_content.php?movieid=<?php echo $row['movieId']; ?>" class="btn btn-default"><b>View More</b></a>             
            </div>
          </div>
        </div>
        <?php 
            }
        ?>
    </div>
    </div>
        <br><br>
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
    </div>
</body>
</html>
</div>
</body>
</html>

