<?php
$dbhost = 'localhost';
$dbuser = 'admin';
$dbpass = 'admin';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully<br />';
$sql = "CREATE TABLE commentdetails1( 
       commentId INT AUTO_INCREMENT, 
       userId INT(10) NOT NULL, 
	   name VARCHAR(255) NOT NULL, 
       movieId INT(11) NOT NULL, 
	   body VARCHAR(255) NOT NULL, 
       PRIMARY KEY ( commentId ),
		FOREIGN KEY(userId) REFERENCES userdetails(userId),
		FOREIGN KEY(movieId) REFERENCES moviedetails(movieId)); ";
mysql_select_db( 'imdbclone_db' );
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not create table: ' . mysql_error());
}
echo "Table created successfully\n";
mysql_close($conn);
?>