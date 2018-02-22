<?php // Cancel Class Script, Sets Status to canceled and emails students of change
session_start();

// Error Reporting for testing
ini_set('display_errors', 1); ini_set('log_errors',1); error_reporting(E_ALL); mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Set Variables Empty
$ID = "";

// Require Database Connection
require '../db/academy/db.php';

// Prepare And Bind Statment
$sql = "UPDATE class SET Status=?, Description=? WHERE ID=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('sss', $status, $desc, $id);

$id = $_SESSION['id'];
$status = "Canceled";
$desc = $_POST['desc'];

if($stmt->execute()){ 
	// Set Success Message
	$_SESSION['successMessage'] = "<i class='fa fa-check' aria-hidden='true'></i> <strong>Success!</strong> This course was canceled!";
	
	// Get Course Details
	$sql = "SELECT * FROM class WHERE ID='".$id."'";
	$result = $mysqli->query($sql);
	
	// Retrieve Course ID
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()) {
			$ID = $row['ID'];
			$courseID = $row['classID'];
			$courseName = $row['className'];
		}
	} else {
		// Error 302 Couldn't Find matching parameters
		$_SESSION['failMessage'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Error!</strong> Couldn't find matching parameters.";
		$_SESSION['errorCode'] = "302";
		header("location: ../../../../view-course.php?id=$id");
	}
	
	// Email Students Of Cancellation
	$sql = "SELECT * FROM roster WHERE CourseID='".$courseID."')";
	$result = $mysqli->query($sql);
	
	// Retrieve Roster Info
	if($result->num_rows > 0) { //ID #3
		while($row = $result->fetch_assoc()) {
			$email = $row['Email'];
			$name = $row['StudentName'];
			require "../mail/cancelMail.php";
		}
	} else {
		// Error 302 Couldn't Find matching parameters
		$_SESSION['failMessage'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Error!</strong> Couldn't find matching parameters.";
		$_SESSION['errorCode'] = "302 #3";
		header("location: ../../../../view-course.php?id=$id"); 
	}
		
	// Redirect to Academy Page
	header("location: ../../../../academy.php");
	//echo $id;
} else {
	$_SESSION['failMessage'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Error!</strong> Could not execute request.";
	$_SESSION['errorCode'] = "300";
	header("location: ../../../../view-course.php?id=$id");
}

$stmt->close();
