<?php
ob_start();
session_start();
if( isset($_SESSION['user'])){
    if($_SESSION['user'] == 1){
        header("Location: adminpage.php");
    } else{
        header("Location: userpage.php");
    }
}
include_once 'dbconnect.php';

$error = false;

if ( isset($_POST['signup']) ) {

    // clean user inputs to prevent sql injections

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    $cpass = trim($_POST['cpass']);
    $cpass = strip_tags($cpass);
    $cpass = htmlspecialchars($cpass);

    //basic email validation
    if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = true;
		echo "<script type='text/javascript'>alert('Enter Valid Email Address.');</script>";
    } else {
        // check email exist or not
        $query = "SELECT user_name FROM userdetails WHERE user_name='$email'";
        $result = mysql_query($query);
        $count = mysql_num_rows($result);
        if($count!=0){
            $error = true;
            echo "<script type='text/javascript'>alert('Provided Email is already in use.');</script>";
        }
    }
    // password validation
    if (empty($pass)){
        $error = true;
        echo "<script type='text/javascript'>alert('Please enter password.');</script>";
    } else if(strlen($pass) < 6) {
        $error = true;
        echo "<script type='text/javascript'>alert('Password must have atleast 6 characters.');</script>";
    }
	
	// confirm password validation
    if (empty($cpass)){
        $error = true;
        echo "<script type='text/javascript'>alert('Please enter password.');</script>";
    } else if(strlen($cpass) < 6) {
        $error = true;
        echo "<script type='text/javascript'>alert('Password must have atleast 6 characters.');</script>";
    }
	if(!($pass == $cpass)){
		$error = true;
        echo "<script type='text/javascript'>alert('Password does not match.');</script>";
	}
    // if there's no error, continue to signup
    if( !$error ) {

        $query = "INSERT INTO userdetails(user_name,user_password) VALUES('$email','$pass')";
        $res = mysql_query($query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            unset($email);
            unset($pass);
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
        }

    }
}
?>
<?php
// Start the session
session_start();
require_once 'dbconnect.php';

// it will never let you open index(login) page if session is set
if( isset($_SESSION['user'])){
    if($_SESSION['user'] == 1){
        header("Location: adminpage.php");
    } else{
        header("Location: userpage.php");
    }
}

$error = false;

if( isset($_POST['login']) ) {

    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    // prevent sql injections / clear user invalid inputs

    if(empty($email)){
        $error = true;
        echo "<script type='text/javascript'>alert('Enter Email Address.');</script>";
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = true;
        echo "<script type='text/javascript'>alert('Enter Valid Email Address.');</script>";
    }

    if(empty($pass)){
        $error = true;
        echo "<script type='text/javascript'>alert('Please enter password.');</script>";
    }

    // if there's no error, continue to login
    if (!$error) {

        $res=mysql_query("SELECT userId, user_name, user_password FROM userdetails WHERE user_name='$email'");
        $row=mysql_fetch_array($res);
        $count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
		//admin
        if( $count == 1 && $row['user_password']==$pass && $row['userId']==1) {
            $_SESSION['user'] = $row['userId'];
            header("Location: adminpage.php");
        } else {//normal user
            $res=mysql_query("SELECT userId, user_name, user_password FROM userdetails WHERE user_name='$email'");
            $row=mysql_fetch_array($res);
            $count = mysql_num_rows($res);
            if( $count == 1 && $row['user_password']==$pass ){
                $_SESSION['user'] = $row['userId'];
                header("Location: userpage.php");
            } else {
				echo "<script type='text/javascript'>alert('Username or password invalid');</script>";
            }
        }

    }

}
?>
<?php
session_start();
require_once 'dbconnect.php';

if(isset($_POST['viewmore'])){
	if ( isset($_SESSION['user'])=="" ){
	echo "<script type='text/javascript'>alert('You Need To Login First To View More Details');</script>";
}
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="xormov.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <script src="typeahead.min.js"></script>
    <title>Xoriant Movies</title>
    <script>
    $(document).ready(function(){
    $('input.typeahead').typeahead({
        name: 'typeahead',
        remote:'search.php?key=%QUERY',
        limit : 10
    });
	});
    </script>
</head>
<body>

<div id="myModalIn" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2F4F4F;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center" style="font-size: 30px; color: #E5C500; font-family: Yanone Kaffeesatz;"><b>Login To Your Account</b></h4>
            </div>
            <div class="modal-body" style="background-color: #2F4F4F;">
                <form method="post" action="<?php $_PHP_SELF ?>">
                    <input align="center" type="text" name="email" placeholder="Email Id">
                    <input align="center" type="password" name="pass" placeholder="Password (min 6 characters)">
                    <input align="center" type="submit" name="login" class="login loginmodal-submit" value="Login">
                </form>
            </div>
            <div class="modal-footer" style="background-color: #2F4F4F;">
                <button type="button" style="font-size: 20px; background-color: #E5C500; color: #000000; font-family: Yanone Kaffeesatz;"class="btn btn-default" data-dismiss="modal"><b>Close</b></button>
            </div>
        </div>

    </div>
</div>
<div id="myModalUp" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2F4F4F;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center" style="font-size: 30px; color: #E5C500; font-family: Yanone Kaffeesatz;"><b>Register Your Account</b></h4>
            </div>
            <div class="modal-body" style="background-color: #2F4F4F;">
                <form method="post" action="<?php $_PHP_SELF ?>">
                    <input type="text" name="email" placeholder="Email Id">
                    <input type="password" name="pass" placeholder="Password (min 6 characters)">
                    <input type="password" name="cpass" placeholder="Confirm Password">
                    <input type="submit" name="signup" class="login loginmodal-submit" value="Sign Up">
                </form>
            </div>
            <div class="modal-footer" style="background-color: #2F4F4F;">
                <button type="button" style="font-size: 20px; background-color: #E5C500; color: #000000; font-family: Yanone Kaffeesatz;" class="btn btn-default" data-dismiss="modal"><b>Close</b></button>
            </div>
        </div>

    </div>
</div>
<div id="mainbody">
    <nav class="navbar navbar-inverse" style = "background-color : #E5C500; color: white;border: 1px solid #E5C500; ">
  <div class="container-fluid">
    <div class="navbar-header">
	  <img class="mainimage" src="camxor.png">
    </div>
	      <a class="navbar-brand" style="font-size: 20px; font-family: Lobster; margin-top:-23px ;color : black;"><h2><b>Xoriant<br>Movies</b></h2></a>
	      <div class="bs-example">
        <input type="text" name="typeahead" class="typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Search Movie ..." >
        </div>
    <ul class="nav navbar-nav navbar-right">
      <li><button data-toggle="modal" type="button" data-target="#myModalIn" class="btn btn-default" id="signin"><b>Sign In</b></button></li>
      <li><button data-toggle="modal" type="button" data-target="#myModalUp" class="btn btn-default" id="signup"><b>Sign Up</b></button></li>
    </ul>
  </div>
</nav>

    <div id="section1">
    <div class="container-fluid">
        <div id="img">
            <img class="image1" src="assignxor.jpg">
        </div>
        <div id="img2">
            <img class="xorcam" src="yellowcam.png">
        </div>
        <h2 id="welcome"><b>Welcome To Xoriant Movies</b></h2>
        <div id="downarrow">
            <a href="#section2"><input type="image" class="imagearr" src="downarrow.png"></a>
        </div>
        </div>
    </div>
    <div id="section2">
        <h1 style="font-size: 50px; font-family: Lobster;color: #E5C500;">Most Watched Movies</h1>
        <br><br><br>
    <?php
        include 'dbconnect.php' ;
        include 'functions.php';
        $movie_set = get_all_movies();
    ?>
    <div class="row">
        <?php 
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
              <form action="<?php $_PHP_SELF ?>" method="POST">
              <button align="center" style="font-size: 20px; background-color: #E5C500; font-family: Yanone Kaffeesatz; border-radius:5px; border: 1px solid #000000;margin-left:70px; width:50%" name="viewmore" class="btn btn-default"><b>View More</b></button>  
              </form>            
            </div>
          </div>
        </div>
        
        <?php 
            }
        ?>
    </div>
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
</div>
</body>
</html>