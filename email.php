<?php
include 'header.php';

if(isset($_POST) === true && empty($_POST) === false){

$avg_data = array(
	'date1' => $_POST['date1'],
	'date2' => $_POST['date2'],
	'car_no'	=> $_POST['car_no'],
	'email'	=> $_POST['email']
	);

$date1 = mysql_real_escape_string($avg_data['date1']);
$date2 = mysql_real_escape_string($avg_data['date2']);
$car_no = mysql_real_escape_string($avg_data['car_no']);
$email = mysql_real_escape_string($avg_data['email']);

$body = "<h3> These are the fuelling details for the car " . $car_no . " from the dates " . $date1 . " to " . $date2 ."</h3>";
$body .= "<table border='1'>
<tr>
<th>Date:</th>
<th align='center'> Car Number: </th>
<th align='center'> Kilo Meter: </th>
<th align='center'> Driver: </th>
<th align='center'> Bill Amount: </th>
<th align='center'> Advance: </th>
</tr>";

$query = mysql_query("
	SELECT * 
	FROM `$car_no`
	WHERE DATE(fuelling_date) 
	BETWEEN'$date1' AND '$date2'
	AND `car_no` = '$car_no'
	ORDER BY `fuelling_date`, `car_no`
	") or die(mysql_error());

while($row = mysql_fetch_array($query)){
$body.="<tr>";
$body.="<td>" . $row['fuelling_date'] . "</td>";
$body.="<td>" . $row['car_no'] . "</td>";
$body.="<td>" . $row['km'] . "</td>";
$body.="<td>" . $row['driver_name'] . "</td>";
$body.="<td>" . $row['bill_amount'] . "</td>";
$body.="<td>" . $row['advance'] . "</td>";
$body.="</tr>";
}

$body.="</table>";
$body.="<br>For any issues with the software, please contact Rohan M at rohan@rohancars.com";
$headers = "From: fuelling@rohantours.com" . strip_tags($_POST['req-email']) . "\r\n";
$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

if (mysql_num_rows($query) == 0) {
  
		echo 'Sorry, there are no entries for the given dates... <br><br>';

} else {

	   mail($email, 'Fuel Details from '. $date1 . ' to ' . $date2, $body, $headers);	

	   echo '<strong> Mail sent to: '. $email . '</strong><br><br>';
}

	  
}


?>

This form will send the entries of a car for the given dates to the email provided. <br><br>

<form action="" method="post">
   
From: <input type="date" name = "date1" required ="required"><br><br>
To: <input type="date" name = "date2" required ="required"><br><br>
Car Number: <input type="text" name = "car_no" required ="required"><br><br>
Email Address: <input type="email" name = "email" required ="required"><br><br>
<input type="submit" value="Email Information"><br><br>
</form>

<a href="email.all.php">Email All Car Details</a> <br><br>
<?php include 'footer.php';?>
