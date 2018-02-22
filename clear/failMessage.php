<?php
// Clear $_SESSION['employeeError'] on click
session_start();

if(isset($_SESSION['failMessage'])){
	unset($_SESSION['failMessage']);
}
//echo $_SESSION['employeeError']; // Just to see if it unsets