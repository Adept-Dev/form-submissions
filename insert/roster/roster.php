<?php 
// Assign Student to Course, Update Roster and email student upon assignment
session_start();

// Error Reporting for testing
ini_set('display_errors', 1); ini_set('log_errors',1); error_reporting(E_ALL); mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database Connection
require '../../db/academy/db.php';

// Prepare and Bind
$stmt = $mysqli->prepare("INSERT INTO roster (CourseID, CourseName, StudentID, StudentName, Phone, Email) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $courseID, $courseName, $studentID, $studentName, $phone, $email);

$courseID = $_POST['course'];
$courseName = $_SESSION['className'];
$studentID = $_SESSION['id'];
$studentName = $_SESSION['name'];
$phone = $_SESSION['phone'];
$email = $_SESSION['email'];

// Execute and Display Alerts on View Students
if($stmt->execute()){
	$_SESSION['assignSuccess'] = "<i class='fa fa-check' aria-hidden='true'></i> <strong>Success!</strong> We added $studentName to $courseName's roster!.";
	
	// Query Class Table to get matching course information
	$sql = "SELECT * FROM class WHERE classID='".$courseID."'";
	$result = $mysqli->query($sql);
	
	if($result->num_rows > 0) {
		// Print Data to Table
		$row = $result->fetch_assoc();
		require '../../mail/rosterMail.php';
		header("location: ../../../../view-student.php?id=$studentID");
		
	} else {
		$_SESSION['assignFail'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Oh no!</strong> We couldn't find a course matching that ID! Please verify the course is still active. If you still have troubles then submit a bug report!";
		header("location: ../../../../view-student.php?id=$studentID");
	
	}
	
	// Redirect to profile and display alert
	
} else {
	$_SESSION['assignFail'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Oh no!</strong> We couldn't assign $studentName to $courseName's roster!";
	header("location: ../../../../view-student.php?id=$studentID");
	
}

// Close Statement
$stmt->close();

	
?>