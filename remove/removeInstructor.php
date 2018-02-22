<?php // Remove Instructor Script
session_start();

// Require Database Connection
require '../db/academy/db.php';

// Prepare And Bind Statment
$sql = ("DELETE FROM instructor WHERE ID = ?");
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $id);

$id = $_POST['instructor'];

if($stmt->execute()){
	$_SESSION['successMessage'] = "<i class='fa fa-check' aria-hidden='true'></i> <strong>Success!</strong> Instructor successfully removed!";
	header("location: ../../../../academy.php");
	//echo $id;
} else {
	$_SESSION['failMessage'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Error!</strong> Unsuccessful attempt to DELETE";
	$_SESSION['errorCode'] = "300";
	header("location: ../../../../academy.php");
}

$stmt->close();