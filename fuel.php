<?php
include 'header.php';


if(isset($_POST['entry']) === true && empty($_POST['entry']) === false){

	$data = array(
	'fuelling_date' => $_POST['fuelling_date'],
	'car_no'	=> $_POST['car_no'],
	'km' 			=> $_POST['km'],
	'driver_name' 	=> $_POST['driver_name'],
	//'driver_cell' 	=> $_POST['driver_cell'],
	'bill_amount'	=> $_POST['bill_amount'],
	'advance'	=> $_POST['advance']
	);
//hello
	
	$fields = '`' . implode('`,`', array_keys($data)) . '`';	
	$data = '\'' . implode('\', \'',$data) . '\'';
	mysql_query("INSERT INTO `fuelling`($fields) VALUES ($data)") or die(mysql_error());
	
$car_no = mysql_real_escape_string($_POST['car_no']);

mysql_query("
	CREATE TABLE IF NOT EXISTS `". $car_no ."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fuelling_date` varchar(10) NOT NULL,
  `car_no` int(4) NOT NULL,
  `km` int(7) NOT NULL,
  `driver_name` varchar(15) NOT NULL,
  `bill_amount` float NOT NULL,
  `advance` int(5) NOT NULL,
  PRIMARY KEY (`id`)
)");

mysql_query("INSERT INTO `". $car_no ."`($fields) VALUES ($data)");

	}	
?>

<form action ="" method ="post">
<?php if(isset($_POST['entry']) === true && empty($_POST['entry']) === false){echo '<br>Entry Successful!<br>';}?>	
		<h4>Enter Details: </h4><br>
<ul>
        <li>
        	<label for="name">Date Of Entry:</label>
            <input type="date" size="40" id="email" name = "fuelling_date"/>
        </li>
        <li>
        	<label for="email">Car Number:</label>
            <input type="text" size="40" id="email" name = "car_no"/>
        </li>
         <li>
            <label for="email">KM Reading:</label>
            <input type="text" size="40" id="email" name = "km"/>
        </li>
         <li>
            <label for="email">Car Number:</label>
            <input type="text" size="40" id="email" name = "car_no"/>
        </li>
        <li>
            <label for="email">Driver Name:</label>
            <input type="text" size="40" id="email" name = "driver_name"/>
        </li>
        <li>
            <label for="email">Bill Amount:</label>
            <input type="text" size="40" id="email" name = "bill_amount"/>
        </li>
        <li>
            <label for="email">Advance:</label>
            <input type="text" size="40" id="email" name = "advance"/>
        </li>
	</ul>
    <p>
        <input type="submit" class="action" value="Submit!" name ="entry">
    </p>
	
</form> 

<?php include 'footer.php';?>
