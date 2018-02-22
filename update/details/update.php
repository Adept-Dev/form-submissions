<?php
// Update Form for Details Modal on view-employee.php

// Error Reporting for testing
ini_set('display_errors', 1); ini_set('log_errors',1); error_reporting(E_ALL); mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Start Session
session_start();

// Get Database Connection
require '../../db/employees/update/db.php';

// Prepare and Bind Statement
$stmt = $mysqli->prepare("UPDATE employees SET FirstName=?, Middle=?, LastName=?, Address=?, City=?, State=?, Zipcode=? WHERE UserID=?");
$stmt->bind_param("ssssssss", $fname, $middle, $lname, $address, $city, $state, $zipcode, $userID );

// Putting Data from Form into variables
$fname = $_POST['firstName'];
$middle = $_POST['middle'];
$lname = $_POST['lastName'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zipcode = $_POST['zipcode'];
$userID = $_SESSION['id'];

// Execute Statement
if($stmt->execute()){
	$_SESSION['successMessage'] = "<strong>Success!</strong> Employee Details Successfully Updated!";
	header('location: ../../../../view-employee.php?id=' . $userID. '');
		
} else {
	$_SESSION['failMessage'] = "<strong>Uh Oh..</strong>Employee Details Failed To Update!";
	header('location: ../../../../view-employee.php?id=' . $userID. '');
}

// Close Statement
$stmt->close();
?>