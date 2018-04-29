<?php
	if (!isset($_GET['bookingid'])) {
		echo "<script>window.location='mdashboard.php'</script>";
	}

	session_start();

	if (!(isset($_SESSION['managerauth']) || isset($_SESSION['staffauth']))) {
		echo "<script>window.location='../adminlogin.php'</script>";
	}

	include('../dbconfig/dbconfig.php');


	$acceptbookingid = $_GET['bookingid'];
	$checkbookingsql = mysql_query("select * from bookings where bookingid = '$acceptbookingid'") or die(mysql_error());
	$rowcheckbooking = mysql_fetch_assoc($checkbookingsql);

	$customerid = $rowcheckbooking['customerid'];
	$getcustomer = mysql_query("select * from customers where customerid = '$customerid'") or die(mysql_error());
	$rowcustomer = mysql_fetch_assoc($getcustomer);
	$customeremail = $rowcustomer['customeremail'];



	$staffid = $_SESSION['staffid'];

	mysql_query("UPDATE Bookings SET confirmstatus = 'confirmed', staffid = '$staffid' where bookingid = '$acceptbookingid'");
	echo "<script>window.location='bookingmanagement.php'</script>";

	require '../sendemail/phpmailer/PHPMailerAutoload.php';
    $email = 'xerocarrental@gmail.com';                    
    $password = 'xerocarrental123';
    $to_id = $customeremail;
    $message = 'Your Booking has been accepted! Please go to Reservation Page to view detail of your reservation! You can cancel your reservation if your pickup date is 5 days away from today!';
    $subject = 'Booking Accepted!';
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
	   echo '<script>alert("Booking Confirmation Completed"); window.location.href = "bookingmanagement.php";</script>';
	}
?>