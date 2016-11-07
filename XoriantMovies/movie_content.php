<?php 
session_start();
// Error reporting:
error_reporting(E_ALL^E_NOTICE);

include "dbconnect.php";
include "comment.class.php";


/*
/	Select all the comments and populate the $comments array with objects
*/
global $link;
$comments = array();
$result = mysql_query("SELECT * FROM commentdetails ORDER BY commentId ASC");

while($row = mysql_fetch_assoc($result))
{
	$comments[] = new Comment($row);
}


$userid= $_SESSION['user'];
if($userid == 1){
	$uname="Admin";
}else{
$res=mysql_query("SELECT userId, user_name FROM userdetails WHERE userId='$userid'");
$row=mysql_fetch_array($res);
$uname=$row['user_name'];
}
//echo "<script type='text/javascript'>alert('$userid');</script>";
global $movieid;
$movieid =$_SESSION["mid"]=$_GET["movieid"];
$res = mysql_query("SELECT * FROM moviedetails WHERE movieId='$movieid'");
$row = mysql_fetch_array($res);
//echo "<script type='text/javascript'>alert('$movieid');</script>";
if(mysql_num_rows($res) > 0)
{
	//echo "all good";
}
else
{
	echo "pls check";
}
$genreid = $row["genreId"];
$res2 = mysql_query("select genreName from genredetails where genreId = '$genreid'");
$row2 = mysql_fetch_array($res2);

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
<!doctype html>
<html>
<head>
<title>XoriantMovies</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="rate.css">
<link rel="stylesheet" href="footerman.css">
<link rel="stylesheet" type="text/css" href="styles.css" />
<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<script type="text/javascript" src="script.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
<style>
#movietitle{
	text-transform : uppercase;
	font-weight : bold;
	font-size: 40px;
	margin-top: 50px;
	color: #E5C500;;
	font-family: Yanone Kaffeesatz;
}
.container-fluid{
	background-color:black;
	margin-top: -20px;
}
.jumbotron{
	background-color : #000000;
	margin-top: 20px;
}
.actors{
	color:#E5C500;
	font-family: Yanone Kaffeesatz;
}
.desc{
	color:#E5C500;
	font-family: Yanone Kaffeesatz;
}
#section-1{
	margin-top: 20px;
}
#submitrate{
	border:2px solid #E5C500;
	font-family: Yanone Kaffeesatz;
	font-size: 20px;
	color: #E5C500;
	background-color: black;
	margin-top: -60px;
	margin-left: 120px;
}
p{
	font-size: 20px;
	color: #E5C500;
	font-family: Yanone Kaffeesatz;
}
</style>
</head>

<body style = "background-color : black ;">
<div id="myModalCP" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2F4F4F;;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center" style="font-size: 30px; color: #E5C500; font-family: Yanone Kaffeesatz;"><b>Change Password</b></h4>
            </div>
            <div class="modal-body" style="background-color: #2F4F4F;;">
                <form method="post" action="<?php $_PHP_SELF ?>">
                    <input style="height: 45px; font-size: 16px;width: 50%;margin-bottom: 10px; background: whitesmoke;margin-left: 130px;border: 1px solid #d9d9d9;border-top: 1px solid #c0c0c0;padding: 0 8px;" type="password" name="oldpass" placeholder="Old Password">
                    <input style="height: 45px; font-size: 16px;width: 50%;margin-bottom: 10px; background: whitesmoke;margin-left: 130px;border: 1px solid #d9d9d9;border-top: 1px solid #c0c0c0;padding: 0 8px;" type="password" name="newpass" placeholder="New Password (min 6 characters)">
                    <input style="height: 45px; font-size: 16px;width: 50%;margin-bottom: 10px; background: whitesmoke;margin-left: 130px;border: 1px solid #d9d9d9;border-top: 1px solid #c0c0c0;padding: 0 8px;" type="password" name="cpass" placeholder="Confirm Password">
                    <input style="border: 0px;color: #000;background-color: #E5C500;padding: 10px 0px;margin-top: 20px;font-family: Yanone Kaffeesatz;font-size: 25px;width: 50%;display: block;margin-bottom: 10px;margin-left: 130px;position: relative;"type="submit" name="changepass" class="change changemodal-submit" value="Submit">
                </form>
            </div>
            <div class="modal-footer" style="background-color: #2F4F4F;;">
                <button type="button" style="font-size: 20px; background-color: #E5C500; color: #000000; font-family: Yanone Kaffeesatz;" class="btn btn-default" data-dismiss="modal"><b>Close</b></button>
            </div>
        </div>

    </div>
</div>
<?php

$movieid=$_GET['movieid'];
$res=mysql_query("SELECT * FROM moviedetails WHERE movieId='$movieid'");
$row=mysql_fetch_array($res);
$_SESSION['mname']=$row['movieName'];
$mrate=$row['movieRate'];

if(isset($_POST['subrate'])){
    if(isset($_POST['star5'])){
        $urate=$_POST['star5'];
    } else if(isset($_POST['star4'])){
        $urate=$_POST['star4'];
    }else if(isset($_POST['star3'])){
        $urate=$_POST['star3'];
    }else if(isset($_POST['star2'])){
        $urate=$_POST['star2'];
    }else if(isset($_POST['star1'])){
        $urate=$_POST['star1'];
    }
    $mrate=($mrate+$urate)/2;
    $mrate=number_format($mrate, 1);
    $res=mysql_query("UPDATE moviedetails SET movieRate='$mrate' WHERE movieId='$movieid'");
    if(res){
        //echo "<script type='text/javascript'>alert('Thankyou for your Feedback');</script>";
    } else {
        echo "<script type='text/javascript'>alert('Error');</script>";
    }
}

?>
	<div id="header">
        <img class="mainimage" src="camxor.png">
        <h2 id="para1"><b>Xoriant<br>Movies</b></h2>
        <div class="dropdown" style="font-size: 20px; font-family: Yanone Kaffeesatz;">
            <button class="dropbtn"><span class="glyphicon glyphicon-user"></span> Hi, <?php echo $uname; ?> <span class="glyphicon glyphicon-menu-down"></span></button>
            <div class="dropdown-content">
                <a href="#" data-toggle="modal" data-target="#myModalCP">Change Password</a>
                <a href="logout.php?logout">Sign Out</a>
            </div>
        </div>
    </div>
<div id="section-1">
	<div class="container-fluid">
		<div class="jumbotron">
			<div class="row">
				<div class="col-md-4" > 
					<img class="img-responsive" style="border: 2px solid #E5C500; margin-top: 50px;height:550px; width:400px;" src="file_display.php?id=<?php echo $movieid;?>"><br>
				</div>
				<div class="col-md-8">
					<h3 id="movietitle"><?php echo $row["movieName"];?></h3>
					<strong><pre><?php echo $row["movieYear"]; ?> | <?php echo $row["movieTime"]; ?> min | <?php echo $row2["genreName"]; ?></pre> </strong>
					<h4 class="actors"><b style="font-size: 30px;">Cast :</b></h4>
					<div class="desc"><p><?php echo $row["movieCast"];?></p></div>
					<h4 class="actors"><b style="font-size: 30px;">Director :</b></h4>
					<div class="desc"><p><?php echo $row["movieDirect"];?></p></div>
					<h4 class="actors"><b style="font-size: 30px;">Description : </b></h4>
					<div class="desc"><p><?php echo $row["movieDesp"]; ?></p></div>
					<p class="actors"><b style="font-size: 30px;">Average Rating:</b></p>
					<div class="stars"><span class="stars"></span><p id="crate"></p></div>	<br>
					<b style="font-size: 30px; color: #E5C500; font-family: Yanone Kaffeesatz;"><h4>Critic Rating:</b></h4><br>
					<div class="stars" style="margin-top: -10px;">
						<form action="<?php $_PHP_SELF ?>" method="POST">
							<input class="star star-5" value="5" id="star-5" type="radio" name="star5"/>
							<label class="star star-5" for="star-5"></label>
							<input class="star star-4" value="4" id="star-4" type="radio" name="star4"/>
							<label class="star star-4" for="star-4"></label>
							<input class="star star-3" value="3" id="star-3" type="radio" name="star3"/>
							<label class="star star-3" for="star-3"></label>
							<input class="star star-2" value="2" id="star-2" type="radio" name="star2"/>
							<label class="star star-2" for="star-2"></label>
							<input class="star star-1" value="1" id="star-1" type="radio" name="star1"/>
							<label class="star star-1" for="star-1"></label>
							<button name="subrate" id="submitrate" class="btn btn-default"><b>Submit</b></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="section-2">
		<div class= "container-fluid">
		<div class="row">
			<div class="col-md-7">
				<div class="video-container" style="border: 2px solid #E5C500;">
						<div class="embed-responsive embed-responsive-16by9">
							<?php $ytid = $row["movieLink"]; ?>
							<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $ytid;?>"></iframe>
						</div>		
				</div>
			</div>
			<?php
				
				    $res4 = mysql_query("select movieId,movieName,movieYear from moviedetails where movieId != '$movieid' order by movieId desc");
					
			?>
			<div class="col-md-5">
			<div class="panel panel-default" style="margin-right:10px;">
			<div class="panel-heading" style="background-color: #E5C500; align:center; font-size:20px;"><b>Top Ten Movies</b></div>
			<div class="panel-body" style="background-color: black; max-height:400px; overflow-y: scroll;">
				
					<div class="list-group" >
					
					<?php while($row4 = mysql_fetch_array($res4)){?>
								
							<a  class="list-group-item" href="movie_content.php?movieid=<?php echo $row4["movieId"];?>"> <?php echo $row4["movieName"];?> 
								<?php echo $row4["movieYear"];?></a>
					<?php
						}
					?>
					
					</div>
			</div>
			</div>
			</div>
		</div>
		</div>
	</div>
	<div id="main">
<br>
<br>
<br>
<?php

foreach($comments as $c){
	echo $c->markup();
}

?>

<div id="addCommentContainer" style = "margin-top : 30px;">
	<p>Add a Comment :</p>
	<form id="addCommentForm" method="post" action="">
    	<div>
			<label> Movie:  </label>
			<?php echo $movieid;?>
			<br>
        	<label for="name">Name :</label>                 
        	<input type="" name="name" id="name" value="<?php echo $uname;?>"  />
			
        	<br>
        
            <label for="body">Comment Here :</label>
            <textarea name="body" id="body" cols="20" rows="5" autofocus = "autofocus"></textarea>
            
            <input type="submit" id="submit" value="Submit" />
        </div>
    </form>
</div>

</div>

	<script>
            $(function() {
                $('span.stars').stars();
            });
            $.fn.stars = function() {
                var avg=<?php echo $mrate; ?>;
                return $(this).each(function() {
        // Get the value
                var val = avg;
        // Make sure that the value is in 0 - 5 range, multiply to get width
                var size = Math.max(0, (Math.min(5, val))) * 16;
        // Create stars holder
                var $span = $('<span />').width(size);
        // Replace the numerical value with stars
                $(this).html($span);
                document.getElementById("crate").innerHTML="<b>"+avg.toFixed(1)+"/5</b>";
                });
            }
    </script>

		<div>

		<?php
		include "demo.php";
		?>
		</div>
	
    <footer>
    <?php
    	include "footer.php";
    ?>
    </footer>
</body>
</html>