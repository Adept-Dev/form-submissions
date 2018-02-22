<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer-master/src/Exception.php';
require '../../PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'coldell.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'donotreply@coldell.com';                 // SMTP username
    $mail->Password = 'R&S4TlbcL$p^';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('donotreply@coldell.com', 'Coldell Training Academy');
    $mail->addAddress($email, $studentName);     // Add a recipient
 
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Accepted! Coldell Academy';
    $mail->Body    = '
	<html>
		<head>
		<title>Acceptance Letter for ".$studentName."</title>
		</head>
		<body>
		<h1>Congratulations!</h1>
		<p>You have been assigned to a course with Coldell Training Academy! You can find your course information below.</p>
		<p>Course Info:</p>
		<table>
		<thead>
		<tr>
		<th>Course ID</th>
		<th>Course Title</th>
		<th>Start Date</th>
		<th>Start Time</th>
		<th>End Time</th>
		<th>Instructor</th>
		</tr>
		<thead>
		<tbody>
		<tr>
		<td>'.$row['classID'].'</td>
		<td>'.$row['className'].'</td>
		<td>'.$row['startDate'].'</td>
		<td>'.$row['startTime'].'</td>
		<td>'.$row['endTime'].'</td>
		<td>'.$row['instructor'].'</td>
		</tr>
		</tbody>
		</table>
		<p>Thanks,</p>
		<p>Enrollment Bot</p>
		<p>DO NOT REPLY TO THIS EMAIL. EMAILS ARE NOT MONITORED AND WILL NOT BE RESPONDED TO.</p>
		</body>
		</html>';

    $mail->send();
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
?>