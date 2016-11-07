<?php
session_start();
include_once 'dbconnect.php';

$error = false;

if ( isset($_REQUEST['signup']) ) {

    // clean user inputs to prevent sql injections

    $email = $_REQUEST['user'];
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = $_REQUEST['pass'];
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

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

    // if there's no error, continue to signup
    if( !$error ) {

        $query = "INSERT INTO userdetails(user_name,user_password) VALUES('$email','$pass')";
        $res = mysql_query($query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            unset($name);
            unset($email);
            unset($pass);
            header("Location: adminpage.php");
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
        }

    }


}
?>
    <html>
    <head lang="en">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <link rel="stylesheet" href="xormov.css">
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

    <div id="mainbody">
        <div id="header">
            <img class="mainimage" src="camxor.png">
            <h2 id="para1"><b>Xoriant<br>Movies</b></h2>
        </div>
        <div id="upsection">
            <h4 align="center" style="margin-top:150px; margin-left:430px; font-size: 40px; color: #E5C500; font-family: Yanone Kaffeesatz;"><b>Register Your Account</b></h4>
            <form style="margin-top:250px; margin-left:180px; position: absolute;"method="POST" action="<?php $_PHP_SELF ?>">
                <input align="center" type="text" name="user" placeholder="Email Id">
                <input align="center" type="password" name="pass" placeholder="Password (min 6 characters)">
                <input align="center" type="password" name="cpass" placeholder="Confirm Password">
                <input align="center" type="submit" name="signup" class="login loginmodal-submit" value="Sign Up">
            </form>
        </div>
        <div id="footer1">
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