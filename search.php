<?php
include 'header.php';

if (isset($_POST) === true && empty($_POST) === false){

$avg_data = array(
	'date1' => $_POST['date1'],
	'date2' => $_POST['date2'],
	'car_no'	=> $_POST['car_no']
	);

$date1 = mysql_real_escape_string($avg_data['date1']);
$date2 = mysql_real_escape_string($avg_data['date2']);
$car = mysql_real_escape_string($avg_data['car_no']);
 
$query = mysql_query("
	SELECT * 
	FROM `$car`
	WHERE DATE(fuelling_date) 
	BETWEEN'$date1' AND '$date2'
	ORDER BY `fuelling_date`") or die(mysql_error());

// set output to variables

$body = "<table border='1'>
	<tr>
	<th>Date:</th>
	<th align='center'> Car Number: </th>
	<th align='center'> Kilo Meter: </th>
	<th align='center'> Driver: </th>
	<th align='center'> Bill Amount: </th>
	<th align='center'> Advance: </th>
	<th align='center'> Edit </th>
	</tr>";


	while($row = mysql_fetch_array($query)){
	$body.="<tr>";
	$body.="<td align='center'>" . $row['fuelling_date'] . "</td> &nbsp;";
	$body.="<td align='center'>" . $row['car_no'] . "</td>&nbsp;";
	$body.="<td align='center'>" . $row['km'] . "</td>&nbsp;";
	$body.="<td align='center'>" . $row['driver_name'] . "</td>&nbsp;";
	$body.="<td align='center'>" . $row['bill_amount'] . "</td>&nbsp;";
	$body.="<td align='center'>" . $row['advance'] . "</td>&nbsp;";
	//$body.="<td align='center'> <form action = edit.php?id=".$row['id']." method='post'><input type='submit' name ='edit' value='edit'></form></td>&nbsp;";
	$body.="</tr> ";
	}
	$body.="</table> <br> <br>";
	
	echo $body;

}
?>

<form action="" method="post">
   
From: <input type="date" name = "date1" required ="required"><br><br>
To: <input type="date" name = "date2" required ="required"><br><br>
Car Number: <input type="text" name = "car_no" required ="required"><br><br>
<input type="submit" value="Find Entries"><br><br>
</form>
