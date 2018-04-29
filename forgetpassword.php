<?php

	//to use session
	session_start();

	//for mysql database connection
	include('dbconfig/dbconfig.php');
	$currentpage = 'forgetpassword';
	

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Xero | Forget Password</title>

		<!-- Bootstrap -->
		<link href="style/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="fa/css/font-awesome.min.css" rel="stylesheet">
		<!-- Sweet Alert -->
		<link rel="stylesheet" href="style/sweetalert.css">
		<!-- Custom Style -->
		<link href="style/customstyle.css" rel="stylesheet">
		<!-- Site Logo -->
		<link href = "images/design/logo.png" rel="icon" type="image/png">

	</head>

	<body class="other">

		<?php include '_navigationbar.php'; ?> <!-- navigation bar -->

		<div class="container adjustnavpositon">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-sm-offset-3 main_form" id="main" style="padding: 20px;">
				<h1 style="text-align: center;">Forget Password</h1>
				<hr>
				<?php if(!isset($_SESSION['sentemail'])): ?>
					<form method="post">
						
						<div class="form-group">
							<label for="email">Enter Email</label>
							<input type="email" name="email" id="email" required class="form-control">
						</div>

						<div class="form-group">
							<input type="submit" name="submit" value="Send Email" class="btn btn-primary center-block">
						</div>
					</form>
				<?php elseif(!isset($_SESSION['authyes'])): ?>
					<p style="color:yellow;"><i class="fa fa-info"></i> The Verification Code has been sent to your email! Please Check Your Email!</p>
					<form method="post">
						
						<div class="form-group">
							<label for="inputverificationcode">Enter Verfication Code</label>
							<input type="inputverificationcode" name="inputverificationcode" id="inputverificationcode" required class="form-control">
						</div>

						<div class="form-group">
							<input type="submit" name="verify" value="Verify" class="btn btn-primary center-block">
						</div>
					</form>
				<?php elseif(isset($_SESSION['authyes'])): ?>
					<form method="post">
						<div class="form-group">
							<label for="newpassword">New Password</label>
							<input type="password" name="newpassword" id="newpassword" required pattern=".{8,}" title="8 characters minimum" placeholder="must be at least 8 characters"  class="form-control">
						</div>
						
						<div class="form-group">
							<label for="confirmpassword">Confirm Password</label>
							<input type="password" name="confirmpassword" id="confirmpassword" required  pattern=".{8,}" title="8 characters minimum" placeholder="must be at least 8 characters" class="form-control">
						</div>

						<div class="form-group">
							<input type="submit" name="changepassword" value="Change Password" class="btn btn-primary center-block">
						</div>
					</form>

				<?php endif; ?>
				</div>
			</div>
		</div>

			
	</body>

	<!-- jQuery -->
	<script src="javascripts/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="javascripts/bootstrap.min.js"></script>
	<!-- SweetAlert -->
	<script src="javascripts/sweetalert-dev.js"></script>
	<script>
	</script>

	<?php
	if (isset($_POST['submit'])):
		$verifiedcode = rand(111111, 999999);
        $customeremail = $_POST['email'];
        $getcustomer = mysql_query("select * from customers where customeremail = '$customeremail'") or die(mysql_error());
        $checkcustomer = mysql_num_rows($getcustomer);
        if ($checkcustomer < 1) {
        	echo "<script>swal({
        	title: 'Oops!',
        	text: 'There is no such user with this email address!',
        	type: 'error',
        	timer: 1000,
        	showConfirmButton: false
        	}, function(){
        	window.location.href = 'forgetpassword.php';
        	});</script>";
        }
        else {
        	$rowcustomer = mysql_fetch_assoc($getcustomer);
        	$_SESSION['customerid'] = $rowcustomer['customerid'];
			require 'sendemail/phpmailer/PHPMailerAutoload.php';
		    $email = 'xerocarrental@gmail.com';                    
		    $password = 'xerocarrental123';
		    $to_id = $customeremail;
		    $message = 'Your verification code for changing password is '.$verifiedcode;
		    $subject = 'Verification Code for Forget Password!';
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
				$_SESSION['sentemail'] = true;
				$_SESSION['verifiedcode'] = $verifiedcode;
			   echo "<script>swal({
		            title: 'Success!',
		            text: 'Verification Code has been sent to your email!',
		            type: 'success',
		            timer: 1000,
		            showConfirmButton: false
		            }, function(){
		            window.location.href = 'forgetpassword.php';
		            });</script>";
			}
        }

	elseif (isset($_POST['verify'])):
		$inputverificationcode = $_POST['inputverificationcode'];
		$verifycode = $_SESSION['verifiedcode'];
		if ($inputverificationcode != $verifycode) {
		   echo "<script>swal({
	            title: 'Oops!',
	            text: 'Your Verification Code is wrong!',
	            type: 'error',
	            timer: 1000,
	            showConfirmButton: false
	            }, function(){
	            window.location.href = 'forgetpassword.php';
	            });</script>";
			
		}
		else{
			$_SESSION['authyes'] = true;
			echo "<script>swal({
			title: 'Success!',
			text: 'The Verification Process is Success! Please change the password!',
			type: 'success',
			timer: 1000,
			showConfirmButton: false
			}, function(){
			window.location.href = 'forgetpassword.php';
			});</script>";
		}
	elseif(isset($_POST['changepassword'])):

		$newpassword = $_POST['newpassword'];
		$confirmpassword = $_POST['confirmpassword'];

        if ($newpassword != $confirmpassword) {
            echo "<script>swal({
            title: 'Oops!',
            text: 'Passwords do not match. Please Try Again!',
            type: 'error',
            timer: 1000,
            showConfirmButton: false
            }, function(){
            window.location.href = 'forgetpassword.php';
            });</script>";
        }
        else{
		    if (7 > strlen($newpassword)) {
		        echo "<script>swal({
		        title: 'Oops!',
		        text: 'Password must be at least 8 characters. Please Try Again!',
		        type: 'error',
		        timer: 1000,
		        showConfirmButton: false
		        }, function(){
		        window.location.href = 'forgetpassword.php';
		        });</script>";
		    }
	        else{
	            $newpassword = md5($newpassword);
				$customerid = $_SESSION['customerid'];
                $changepasswordsql = mysql_query("UPDATE customers set customerpassword = '$newpassword' where customerid = '$customerid'") or die(mysql_error());
                session_destroy();
                echo "<script>swal({
                title: 'Success!',
                text: 'Your password is successfully changed! Please Login!',
                type: 'success',
                timer: 1000,
                showConfirmButton: false
                }, function(){
                window.location.href = 'index.php';
                });</script>";
	        }
	    }

    endif;

	?>
</html>