<?php
// Add Instructor to Database

// Database Connection
require '../../db/academy/db.php';

// Prepare & Bind
$stmt = $mysqli->prepare("INSERT INTO instructor (FirstName, LastName, License, ExpireDate) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $firstName, $lastName, $license, $expireDate);

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$license = $_POST['license'];
$expireDate = $_POST['expire'];

// Execute and display alerts on academy.php
if($stmt->execute()){
	$_SESSION['successMessage'] = "<i class='fa fa-check' aria-hidden='true'></i> <strong>Success!</strong> ' . $firstName. ' ' . $lastName. ' was added!";
	header("location: ../../../../academy.php");
} else {
	$_SESSION['failMessage'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Failed!</strong> ' . $firstName. ' ' . $lastName. ' failed to save!";
	header("location: ../../../../academy.php");
}

// Close Statement
$stmt->close();

?>