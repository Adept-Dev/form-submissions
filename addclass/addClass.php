<?php
// Add Class to Database

// Error Reporting for testing
ini_set('display_errors', 1); ini_set('log_errors',1); error_reporting(E_ALL); mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database Connection
require '../../db/academy/db.php';

// Prepare & Bind
$stmt = $mysqli->prepare("INSERT INTO class (classID, className, startDate, endDate, startTime, endTime, instructor, classSize, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $classID, $className, $startDate, $endDate, $startTime, $endTime, $instructor, $classSize, $status);

$classID = mt_rand(1000, 1000000000);
$className = $_POST['class'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$instructor = $_POST['instructor'];
$classSize = $_POST['classSize'];
$status = "Active";

// Execute and display alerts on academy.php
if($stmt->execute()){
	$_SESSION['addClassSuccess'] = "<i class='fa fa-check' aria-hidden='true'></i> <strong>Success!</strong> You added ' . $className. ' to the schedule.";
	header("location: ../../../../academy.php");
} else {
	$_SESSION['addClassFail'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Failed!</strong> ' . $className. ' failed to save!";
	header("location: ../../../../academy.php");
}

// Close Statement
$stmt->close();

?>