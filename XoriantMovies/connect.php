<?php

/* Database config */

$db_host		= 'localhost';
$db_user		= 'admin';
$db_pass		= 'admin';
$db_database		= 'imdbclone_db'; 

/* End config */


$link = @mysql_connect($db_host,$db_user,$db_pass) or die('Unable to establish a DB connection');

mysql_select_db($db_database,$link);

?>