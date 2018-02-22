<?php
// Update Form for Details Modal on view-employee.php

// Error Reporting for testing
ini_set('display_errors', 1); ini_set('log_errors',1); error_reporting(E_ALL); mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Start Session
session_start();

// Get Database Connection
require '../../db/employees/update/db.php';

// Prepare and Bind Statement
$stmt = $mysqli->prepare("UPDATE employees SET PrimaryPhone=?, SecondaryPhone=?, Email=? WHERE UserID=?");
$stmt->bind_param("ssss", $pphone, $sphone, $email, $userID );

// Putting Data from Form into variables
$pphone = $_POST['primaryPhone'];
$sphone = $_POST['secondaryPhone'];
$email = $_POST['email'];
$userID = $_SESSION['id'];

// Execute Statement
if($stmt->execute()){
	$_SESSION['successMessage'] = "<strong>Success!</strong> Employee Contact Information Successfully Updated!";
	header('location: ../../../../view-employee.php?id=' . $userID. '');
		
} else {
	$_SESSION['failMessage'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Uh Oh..</strong>Employee Contact Information Failed To Update!";
	header('location: ../../../../view-employee.php?id=' . $userID. '');
}

// Close Statement
$stmt->close();
?>