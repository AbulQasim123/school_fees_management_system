<?php
		//database_connection.php
	$base_url = 'http://localhost/PHP-PRACTICAL/school_fees_management_system/';
	$connect = new PDO("mysql:host=localhost;dbname=sfms","root","");

	$month_array = array('January','February','March','April','May','June','July','Augest','September','October','November','December');

	
	$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
	$datetime = $date->format('Y-m-d H:i:s');
	

	session_start();

	function is_login(){
		if (isset($_SESSION['admin_id'])) {
			return true;
		}
		return false;
	}

	function is_master_user(){
		if (isset($_SESSION['user_type'])) {
			if ($_SESSION['user_type'] == 'Master') {
				return true;
			}
			return false;
		}
		return false;
	}

	function Generate_student_number($number){
	$output = '';
	$rand = rand(1111,9999);
	$number = $number + $rand;

	$number_length = strlen((string)$number);

	if($number_length == 1)
	{
		$output = 'R00000' . $number;
	}
	else if($number_length == 2)
	{
		$output = 'R0000' . $number;
	}
	else if($number_length == 3)
	{
		$output = 'R000' . $number;
	}
	else if($number_length == 4)
	{
		$output = 'R00' . $number;
	}
	else if($number_length == 5)
	{
		$output = 'R0' . $number;
	}
	else
	{
		$output = 'R' . $number;
	}

	return $output;
}
?>

