<?php
// SSC

// Upload SSC to File System and set path for DB insert

$target_dir = $_SERVER['DOCUMENT_ROOT'] . '/assets/app/employees/sgc/' . $_POST['fname'] . $_POST['lname'] . '/';
$target_file = $target_dir . basename($_FILES['securityCard']['name']);
$uploadOk = 1;
$imgFileType = pathinfo($target_file, PATHINFO_EXTENSION);
$location = '/assets/app/employees/sgc/' . $_POST['fname'] . $_POST['lname'] . '/' . basename($_FILES['securityCard']['name']);


// Check to see if dir already exist if not make one
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/assets/app/employees/sgc/' . $_POST['fname'] . $_POST['lname'])) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . '/assets/app/employees/sgc/' . $_POST['fname'] . $_POST['lname']);
} else {
	$_SESSION['message'] = "Dir already Exist!";
	header('location : error.php');
}
// Check for fake img
if(isset($_POST['submit'])) {
	$check = getimagesize($_FILES['securityCard']['tmp_name']);
	if ($check !== false){
		$_SESSION['message'] = "File is a image!";
		$uploadOk = 1;
	} else {
		$_SESSION['message'] = "File is not a image!";
		$uploadOk = 0;
		header('location : error.php');
	}
}

// Only allow JPG JPEG or PNG
if($imgFileType != "jpg" && $imgFileType != "jpeg" && $imgFileType != "png"){
	$_SESSION['message'] = "Incorrect File Type. Please only upload JPG JPEG or PNG files.";
	header('location : error.php');
}

// Checking to see if uploadOk = 0
if($uploadOk == 0) {
	$_SESSION['message'] = "This file was not uploaded. Please try again.";
	header('location : error.php');
}// Everything is ok ready to move 
else {
	if (move_uploaded_file($_FILES['securityCard']['tmp_name'], $target_file)) {
		$_SESSION['message'] = "File was uploaded!";
	} else {
		$_SESSION['message'] = "File failed to upload!";
		header('location : error.php');
	}
}
// Set Variable for register.php
$ssc = $location;