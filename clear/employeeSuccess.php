<?php
// Clear $_SESSION['employeeError'] on click
session_start();

if(isset($_SESSION['employeeSuccess'])){
	unset($_SESSION['employeeSuccess']);
}
//echo $_SESSION['employeeError']; // Just to see if it unsets