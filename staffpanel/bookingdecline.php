<?php
	if (!isset($_GET['bookingid'])) {
		echo "<script>window.location='mdashboard.php'</script>";
	}

	session_start();
	
	if (!isset($_SESSION['companyauth'])) {

		echo "<script>window.location='../adminlogin.php'</script>";
	}

	include('../dbconfig/dbconfig.php');


	$declinebookingid = $_GET['bookingid'];
	$checkbookingsql = mysql_query("select * from bookings where bookingid = '$declinebookingid'") or die(mysql_error());
	$rowcheckbooking = mysql_fetch_assoc($checkbookingsql);
	$paymentmethod = $rowcheckbooking['paymentmethod'];

	$customerid = $rowcheckbooking['customerid'];
	$getcustomer = mysql_query("select * from customers where customerid = '$customerid'") or die(mysql_error());
	$rowcustomer = mysql_fetch_assoc($getcustomer);
	$customeremail = $rowcustomer['customeremail'];

	$totalcost = $rowcheckbooking['totalcost'];
	if ($paymentmethod == 'paypal') {
		$updatepaypal = mysql_query("update paypalserver set balance = balance + '$totalcost' where customerid = '$customerid'") or die(mysql_error());
	}
	$staffid = $_SESSION['staffid'];

	mysql_query("UPDATE Bookings SET confirmstatus = 'declined', staffid = '$staffid' where bookingid = '$declinebookingid'");

	require '../sendemail/phpmailer/PHPMailerAutoload.php';
    $email = 'xerocarrental@gmail.com';                    
    $password = 'xerocarrental123';
    $to_id = $customeremail;
    $message = 'Your Booking has been declined due to some errors in your reservation form! Please Try Again for another reservation';
    $subject = 'Booking Declined!';
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = $email;
    $mail->Password = $password;
    $mail->setFrom('from@example.com', 'Xero - Support');
    $mail->addReplyTo('donotreply@xerocarrental.com', 'Do not reply');
    $mail->addAddress($to_id);
    $mail->Subject = $subject;
    $mail->msgHTML($message);
    if (!$mail->send()) {
       $error = "Mailer Error: " . $mail->ErrorInfo;
        ?><script>alert('<?php echo $error ?>');</script><?php
    }
	else {
	   echo '<script>alert("Booking Declined Completed"); window.location.href = "bookingmanagement.php";</script>';
	}
?>