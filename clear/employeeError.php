<?php
// Clear $_SESSION['employeeError'] on click
session_start();

if(isset($_SESSION['employeeError'])){
	unset($_SESSION['employeeError']);
}
//echo $_SESSION['employeeError']; // Just to see if it unsets