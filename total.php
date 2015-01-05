<?php
include 'header.php';

if (isset($_POST) === true && empty($_POST) === false){

$avg_data = array(
	'date1' => $_POST['date1'],
	'date2' => $_POST['date2'],
	);

$date1 = mysql_real_escape_string($avg_data['date1']);
$date2 = mysql_real_escape_string($avg_data['date2']);
 
$query = mysql_query("
	SELECT SUM(`bill_amount`) 
	FROM `fuelling`
	WHERE DATE(fuelling_date) 
	BETWEEN'$date1' AND '$date2'
	") or die(mysql_error());

// set output to variables

$total_amount = mysql_fetch_row($query);
$total = $total_amount[0];
echo "<h3> Total fuel amount spent from ". $date1 ." to " . $date2 . " is: &#8377;" . $total . "</h3><br>";
}
?>

Find the total amount spent on fuel for a particular day: <br><br>

<form action="" method="post">   
From: <input type="date" name = "date1" required ="required"><br><br>
To: <input type="date" name = "date2" required ="required"><br><br>
<input type="submit" value="Calculate Amount"><br><br>
</form>
