<?php
session_start();
require_once 'dbconnect.php';
include "comment.class.php";

error_reporting(E_ALL^E_NOTICE);



$userid= $_SESSION['user'];
$res=mysql_query("SELECT userId, user_name FROM userdetails WHERE userId='$userid'");
$row=mysql_fetch_array($res);
$uname=$row['user_name'];

$movieid=$_GET['movieid'];
$res=mysql_query("SELECT * FROM moviedetails WHERE movieId='$movieid'");
$row=mysql_fetch_array($res);
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
        echo "<script type='text/javascript'>alert('Thankyou for your Feedback');</script>";
    } else {
        echo "<script type='text/javascript'>alert('Error');</script>";
    }
}

?>
<html>
<head lang="en">
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="rate.css">
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <title>Xoriant Movies</title>
</head>
<body>
<div id="mainbody">
	<div id="header">
        <img class="mainimage" src="camxor.png">
        <h2 id="para1"><b>Xoriant Movies</b></h2>
        <div class="dropdown" style="font-size: 20px; font-family: Yanone Kaffeesatz;">
            <button class="dropbtn"><span class="glyphicon glyphicon-user"></span> Hi, <?php echo $uname; ?> <span class="glyphicon glyphicon-menu-down"></span></button>
            <div class="dropdown-content">
                <a href="#" data-toggle="modal" data-target="#myModalCP">Change Password</a>
                <a href="logout.php?logout">Sign Out</a>
            </div>
        </div>
    </div>
	<div id="section1">
		<img class="mainimg" src="file_display.php?id=<?php echo $movieid; ?>" height="500" width="350"/>
	</div>
	<div id="text">
		<p><b><?php echo $row['movieName']; ?> (<?php echo $row['movieYear']; ?>) | <?php echo $row['movieTime']; ?>min</b></p>
        <p><?php echo $row['movieDesp']; ?></p>
        <p><b>Director:</b> <?php echo $row['movieDirect']; ?></p>
		<p><b>Average Rating:</b></p>
		<div class="stars">
        <span class="stars"></span>
            <p id="crate"></p><br>
            <p><b>Critic Rating:</b></p>
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
                <button name="subrate" class="btn btn-default" style="color: #FFD700; font-size: 18px; font-family: Yanone Kaffeesatz; border:1px solid #FFD700;"><b>Submit</b></button>
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
    <div id="main" style="margin-top:700px;position: absolute;margin-left: 310px;">

        <?php
            foreach($comments as $c)
            {
                echo $c->markup();
            }
        ?>
        
        <div id="addCommentContainer">
            <p>Add a Comment</p>
            <form id="addCommentForm" method="POST" action="">
                <div>
                    <!--<label for="name">Username :</label>
                    <input type="hidden" name="name" id="name"/>-->
                
                    <label for="body">Comment Here :</label>
                    <textarea name="body" id="body" cols="20" rows="6"></textarea>
                    
                    <input type="submit" id="submit" value="Submit"/>
                </div>
            </form></center>
        </div>

    </div>
</div>
</body>
</html>