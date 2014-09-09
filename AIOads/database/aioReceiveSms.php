<?php

//$con=mysqli_connect("184.73.170.96","tjeyjenthan","Tj4yJ4N7h@N","eshop");
//$con=mysqli_connect("localhost","root","","eshop");
$con=mysqli_connect("localhost","tjeyjenthan","Tj4yJ4N7h@N","eshop");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$content="dia john Phonef Nokiaj 350 0777771542";
$split = explode(' ', $content);

	mysqli_query($con,"INSERT INTO sell_items(name, brand, price,phone_no)
	VALUES ($split[2],$split[3],$split[4],$split[5])");
	mysqli_close($con);
//mysqli_query($con,"INSERT INTO sell_items(name, brand, //price,phone_no)
//VALUES ('Phone','Nokia',35,'0777771542')");
//mysqli_close($con);
?>