<?php
session_start();
// Error Reporting for testing
ini_set('display_errors', 1); ini_set('log_errors',1); error_reporting(E_ALL); mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database Connection file
require '../db/employees/db.php';


// File upload scripts
require '../../../assets/app/employees/ssn/upload.php'; // Commenting out to find problem code
//require '../../../assets/app/employees/id/upload.php';
//require '../../../assets/app/employees/picture/upload.php';
//require '../../../assets/app/employees/w4/upload.php';
//require '../../../assets/app/employees/i9/upload.php';
//require '../../../assets/app/employees/policy/upload.php';
//require '../../../assets/app/employees/drugfreeworkplace/upload.php';
//require '../../../assets/app/employees/emergency/upload.php';
//require '../../../assets/app/employees/dd/upload.php';
//require '../../../assets/app/employees/sgc/upload.php';


// Check connection to database
if($mysqli->connect_error) {
	die("Connection Failed: " . $mysqli->connect_error);
}

// Prepare and Bind Statement
$stmt = $mysqli->prepare("INSERT INTO employees (FirstName, Middle, LastName, Address, City, State, Zipcode, PrimaryPhone, SecondaryPhone, Email, SSN, DateOfBirth, EID, Gender, Ethnicity, sscLoc, Status, JobCode, HireDate, Hours, License, ExpireDate, eapAccess, Password, hash) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssiisisissssisisssss", $fname, $mi, $lname, $address, $city, $state, $zipcode, $primaryPhone, $secondaryPhone, $email, $hashedSsn, $dob, $eid, $gender, $ethnicity, $sscLoc, $status, $jobCode, $hireDate, $hours, $license, $expireDate,  $eap, $hashedPassword, $hash );

/* Current Code Used For Referrence
$stmt = $mysqli->prepare("INSERT INTO employees (FirstName, Middle, LastName, Address, City, State, Zipcode, PrimaryPhone, SecondaryPhone, Email, SSN, DateOfBirth, EID, Gender, Ethnicity, sscLoc, idLoc, pic, Status, JobCode, HireDate, Hours, License, ExpireDate, SecurityCard, W4, I9, Policy, DrugFree, Emergency, DirectDeposit, eapAccess, Password, hash) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssiisisissssssisissssssssssss", $fname, $mi, $lname, $address, $city, $state, $zipcode, $primaryPhone, $secondaryPhone, $email, $hashedSsn, $dob, $eid, $gender, $ethnicity, $sscLoc, $idLoc, $picture, $status, $jobCode, $hireDate, $hours, $license, $expireDate, $sgLoc, $w4, $i9, $policy, $dfw, $emergency, $dd, $eap, $hashedPassword, $hash );
*/

// Putting $_POST into variables to store data
$fname = $_POST['fname'];
$mi = $_POST['mname'];
$lname = $_POST['lname'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zipcode = $_POST['zipcode'];
$primaryPhone = $_POST['primaryPhone'];
$secondaryPhone = $_POST['secondaryPhone'];
$email = $_POST['email'];
$ssn = $_POST['ssn'];
$hashedSsn = password_hash($ssn, PASSWORD_BCRYPT);
$dob = $_POST['dob'];
$eid = $_POST['eid'];
$gender = $_POST['gender'];
$ethnicity = $_POST['ethnicity'];
$sscLoc = $ssc;
//$idLoc = $id;
//$picture = $pic;
$status = $_POST['status'];
$jobCode = $_POST['jobCode'];
$hireDate = $_POST['hireDate'];
$hours = $_POST['hours'];
$license = $_POST['regNumber'];
$expireDate = $_POST['expireDate'];
//$sgLoc = $sgc;
//$w4 = $w4Upload;
//$i9 = $i9Upload;
//$policy = $policyUpload;
//$dfw = $dfwUpload;
//$emergency = $emergencyUpload;
//$dd = $ddUpload;
$eap = $_POST['eap'];
$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$hash = md5(rand(0,1000));

// Add employee to database
if($stmt->execute()) {

	$_SESSION['employeeSuccess'] = "<i class='fa fa-check' aria-hidden='true'></i> <strong>Success!</strong> Employee was successfully saved!";
	header("location: ../../../employees.php");
}
else {
	$_SESSION['employeeError'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Error!</strong> We were not able to save employee please try again.";
	$_SESSION['errorCode'] = "100";
	header("location: ../../../employees.php");
}

/*
// Check if user with that email already exists
$stmt1 = $mysqli->prepare("SELECT Email FROM employees WHERE Email=?");
$stmt1->bind_param("s", $email);
if($stmt1->execute()){
	$stmt1->store_result();
	if($stmt1->num_rows > 0) { // Email exist if a row is present
		
		$_SESSION['employeeError'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Error!</strong> That email is already in use! Please try another email.";
		header("location: ../../../add-employee.php");
	} else { // Email doesn't Exist proceed..
		
		// Add employee to database
		if($stmt->execute()) {

			$_SESSION['employeeSuccess'] = "<i class='fa fa-check' aria-hidden='true'></i> <strong>Success!</strong> Employee was successfully saved!";
			header("location: ../../../employee.php");
		}
		else {
			$_SESSION['employeeError'] = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <strong>Error!</strong> We were not able to save employee please try again.";
			$_SESSION['errorCode'] = "100";
			header("location: ../../../employee.php");
		}
	}
}
*/

/* Old Code Left for Testing

$result = $mysqli->query("SELECT * FROM employees WHERE Email='.$email.'");


// We know user email exists if the rows returned are more than 0
if($email == $row['email']) {
	$_SESSION['message'] = "Employee with that email already exist!";
	header('location: ../../../error.php');
}
else { // Email doesn't exist in database, proceed..
	
	// Add employee to database
	if($stmt->execute()) {
		
		$_SESSION['active'] = 0; //0 until user activates their account with verify.php
        $_SESSION['logged_in'] = true; // So we know the user has logged in
        $_SESSION['message'] =
                
                 "Employee was successfully added! If employee has access to EAP then they will recieve a confirmation email shortly.";
		
		header("location: ../../../success.php");
	}
	else {
        $_SESSION['message'] = 'Registration failed!';
        header("location: ../../../error.php");
    }
}
*/
?>