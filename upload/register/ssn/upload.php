<?php
// SSC

// Upload SSC to File System and set path for DB insert

$target_dir = $_SERVER['DOCUMENT_ROOT'] . '/assets/app/employees/ssn/' . $_POST['fname'] . $_POST['lname'] . '/';
$target_file = $target_dir . basename($_FILES['ssnPic']['name']);
$uploadOk = 1;
$imgFileType = pathinfo($target_file, PATHINFO_EXTENSION);
$location = '/assets/app/employees/ssn/' . $_POST['fname'] . $_POST['lname'] . '/' . basename($_FILES['ssnPic']['name']);


// Check to see if dir already exist if not make one
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/assets/app/employees/ssn/' . $_POST['fname'] . $_POST['lname'])) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . '/assets/app/employees/ssn/' . $_POST['fname'] . $_POST['lname']);
} else {
	$_SESSION['employeeError'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Error!</strong> Directory Error.";
	$_SESSION['errorCode'] = "200";
	header("location: ../../../../add-employee.php");
}
// Check for fake img
if(isset($_POST['submit'])) {
	$check = getimagesize($_FILES['ssnPic']['tmp_name']);
	if ($check !== false){
		$uploadOk = 1;
	} else { // File is not a img
		$_SESSION['employeeError'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Error!</strong> Image Error.";
		$_SESSION['errorCode'] = "201";
		$uploadOk = 0;
		header("location: ../../../../add-employee.php");
	}
}

// Only allow JPG JPEG or PNG
if($imgFileType != "jpg" && $imgFileType != "jpeg" && $imgFileType != "png"){
	$_SESSION['employeeError'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Error!</strong> Invaild File Type.";
	$_SESSION['errorCode'] = "202";
	header("location: ../../../../add-employee.php");
}

// Checking to see if uploadOk = 0
if($uploadOk == 0) {
	$_SESSION['employeeError'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Error!</strong> This file does not meet requirements.";
	$_SESSION['errorCode'] = "203";
	header("location: ../../../../add-employee.php");
}// Everything is ok ready to move 
else {
	if (move_uploaded_file($_FILES['ssnPic']['tmp_name'], $target_file)) {
		
	} else {
		$_SESSION['employeeError'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Error!</strong> Failed to move file to directory.";
		$_SESSION['errorCode'] = "204";
		header("location: ../../../../add-employee.php");
	}
}
// Set Variable for register.php
$ssc = $location;