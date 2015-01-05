<?php
// note: for our system, the given table name is users and the fields are
// username, password, first_name, last_name, email, active 
// if a query fails, add or die(mysql_error());
$connect_error = 'We\'re are experiencing some issues....';
mysql_connect('localhost','rohstar_rohan','tara1945') or die(mysql_error());
mysql_select_db('fuel')or die(mysql_error());
?>