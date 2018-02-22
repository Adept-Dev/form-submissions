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
    $mail->addAddress($email, $name);     // Add a recipient
 
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Course Cancellation';
    $mail->Body    = '
	<html>
		<head>
		<title>Course Cancellation</title>
		</head>
		<body>
		<h1>We are sorry!</h1>
		<p>The course you were assigned to has been canceled! We are sorry for the inconvenience this may cause you. A detailed reason why the course was canceled is listed below. As always this falls under our refund policy. If you have questions about our refund policy please contact us. You can view the refund policy <a href="https://www.coldell.com/refund-policy.html">here</a>.</p>
		<p>Course Info:</p>
		<table>
		<thead>
		<tr>
		<th>Course ID</th>
		<th>Course Title</th>
		<th>Status</th>
		<th>Description</th>
		</tr>
		<thead>
		<tbody>
		<tr>
		<td>'.$courseID.'</td>
		<td>'.$courseName.'</td>
		<td>'.$status.'</td>
		<td>'.$desc.'</td>
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