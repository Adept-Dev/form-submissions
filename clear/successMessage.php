<?php
// Clear $_SESSION['employeeError'] on click
session_start();

if(isset($_SESSION['successMessage'])){
	unset($_SESSION['successMessage']);
}
//echo $_SESSION['employeeError']; // Just to see if it unsets