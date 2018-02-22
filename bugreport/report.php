<?php
//Bug Report

// Starting Session
session_start();

// Database Connection
require '../db/employees/db.php';


// Prepare and Bind 
$stmt = $mysqli->prepare("INSERT INTO bugReport (ReportNumber, Name, Email, Phone, PageURL, Description) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssss", $report, $name, $email, $phone, $url, $desc);

$report = mt_rand(1000, 1000000000);
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$url = $_POST['url'];
$desc = $_POST['desc'];

// Execute Statement and email form to IT Dept
if($stmt->execute()) {
	// Setting Alert Message
	$_SESSION['bugSuccessMessage'] = "<strong>Success!</strong> You successfully reported a Bug! We will deal with it!";
	
	// Email
	$to = "krisc@coldell.com";
	$subject = "Bug Report " . $report;
	$message = "
	<html>
		<body>
			<h2>Bug Report!</h2>
			<table>
				<thead>
					<tr>
						<th>Report #</th>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>URL</th>
						<th>Description</th>
					</tr>	
				</thead>
				<tbody>
					<tr>
						<td>" . $report. "</td>
						<td>" . $name. "</td>
						<td>" . $email. "</td>
						<td>" . $phone. "</td>
						<td>" . $url. "</td>
						<td>" . $desc. "</td>
					</tr>
				</tbody>
			</table>
			<h4>-Bug Reporter Bot</h4>
			<p>Please do not reply to this email.</p>
		</body>
	<html>
	";
	$from = "noreply@coldell.com";
	
	mail($to, $subject, $message, $from);
	
	// Redirect back to Report page
	header("location: ../../../bug-report.php");
	
} else {
	$_SESSION['bugFailMessage'] = "<strong>Uh Oh..</strong> We are having trouble reporting this bug. Please try again later!";
	header("location: ../../../bug-report.php");
}

// Close statement
$stmt->close();





?>