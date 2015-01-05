<?php
include 'header.php';

if(isset($_POST) === true && empty($_POST) === false){

$avg_data = array(
	'date1' => $_POST['date1'],
	'date2' => $_POST['date2'],
	'car_no'	=> $_POST['car_no']
	);

$date1 = mysql_real_escape_string($avg_data['date1']);
$date2 = mysql_real_escape_string($avg_data['date2']);
$car = mysql_real_escape_string($avg_data['car_no']);
 
/*$body = "<table border='1'>
<tr>
<th>Date:</th>
<th align='center'>Car Number:</th>
<th align='center'>Kilo Meter:</th>
<th align='center'>Driver:</th>
<th align='center'>Bill Amount:</th>
<th align='center'>Advance:</th>
</tr>";
*/
$max= mysql_query("
	SELECT max(km) 
	FROM `$car` 
	WHERE `car_no` = '$car'
	AND DATE(fuelling_date) 
	BETWEEN'$date1' AND '$date2'
	") or die(mysql_error());

$max = mysql_fetch_row($max);
//convert the km from string data to an int and save it into max_km
$max_km = (float)$max[0];

$min = mysql_query("
	SELECT min(km) 
	FROM `$car` 
	WHERE DATE(fuelling_date) 
	BETWEEN'$date1' AND '$date2'
	") or die(mysql_error());

$min = mysql_fetch_row($min);
$min_km = (float)$min[0];

$last_sum = mysql_query("
	SELECT bill_amount 
	FROM `$car`  
	WHERE DATE(fuelling_date) 
	BETWEEN '$date1' AND '$date2'
	ORDER BY id DESC 
	LIMIT 1") or die(mysql_error());
//that query returns the very last entry in the table 
$last_amount = mysql_fetch_row($last_sum);
$last_amount = (float)$last_amount[0];

$sum = mysql_query("
	SELECT sum(bill_amount) 
	FROM `$car`  
	WHERE DATE(fuelling_date) 
	BETWEEN'$date1' AND '$date2'
	") or die(mysql_error());

if (mysql_num_rows($max) == 0 && mysql_num_rows($min) == 0 && mysql_num_rows($last_sum) == 0 && mysql_num_rows($sum) == 0) {
  
		echo 'Sorry, there are no entries for the given dates... <br><br>';

} else {

$total_amount = mysql_fetch_row($sum);
$total_amount = (int)$total_amount[0];
//account to remove the very last entry in order to calculate the avg
$total_amount = $total_amount - $last_amount;

$total_km = $max_km - $min_km;

$avg = ($total_amount/$total_km);

$avg = round($avg, 2);

echo '<strong> The Average for the car ' . $car . ' from ' . $date1 . ' to ' . $date2 . ' is: </strong><br><br>'; 

echo "Total Amount = ".$total_amount."<br>";
echo "Total KM = ".$total_km."<br>";
echo "Average RS/KM = ".$avg."<br><br>";
echo "Total amount is exclusive of the last fill for average purposes.";

	}

}

?>

This form will help display the average of a car for the given dates. <br><br>

<form action="" method="post">
 <ul>
<li>
        	<label for="name">From:</label>
            <input type="date" size="40" id="email" name = "date1"/>
</li>
<li>
        	<label for="name">To:</label>
            <input type="date" size="40" id="email" name = "date2"/>
</li>
<li>
        	<label for="name">Car Number:</label>
            <input type="text" size="4" id="email" name = "car_no"/>
</li>
<input type="submit" value="Find Average"><br><br>
</form>

