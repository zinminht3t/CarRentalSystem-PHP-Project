<?php
	session_start();
	include('../dbconfig/dbconfig.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Xero | Driver Forget Password</title>

		<!-- Bootstrap -->
		<link href="../style/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="../fa/css/font-awesome.min.css" rel="stylesheet">
		<!-- Site Logo -->
		<link href = "../images/design/logo.png" rel="icon" type="image/png">
		<!-- Font Awesome -->
		<link href="../style/chosen.min.css" rel="stylesheet">
		<!-- Sweet Alert -->
		<link rel="stylesheet" href="../style/sweetalert.css">

		<!-- Custom Theme Style -->
		<link href="../style/custom.min.css" rel="stylesheet">

	</head>

	<body class="login">
		<div>
			<a class="hiddenanchor" id="signup"></a>
			<a class="hiddenanchor" id="signin"></a>

			<div class="login_wrapper">
			<div class="animate form login_form">
			<section class="login_content">



				<?php if(!isset($_SESSION['driversentemail'])): ?>
					<form method="post">
						
						<div>
							<label for="email">Enter Email</label>
							<input type="email" name="email" id="email" required class="form-control">
						</div>

						<div>
							<input type="submit" style="margin-left: 0;"  name="submit" value="Send Email" class="btn btn-default">
						</div>
						<hr>
						<br>
						<div class="separator">

							<div>
								<h1><i class="fa fa-xing"></i> Xero</h1>
								<p>2017 All Rights Reserved @ Xero Company Limited</p>
							</div>
						</div>
					</form>
				<?php elseif(!isset($_SESSION['driverauthyes'])): ?>
					<p style="color:white;"><i class="fa fa-info"></i> The Verification Code has been sent to your email! Please Check Your Email!</p>
					<form method="post">
						
						<div>
							<label for="inputverificationcode">Enter Verfication Code</label>
							<input type="inputverificationcode" name="inputverificationcode" id="inputverificationcode" required class="form-control">
						</div>

						<div>
							<input type="submit" style="margin-left: 0;"  name="verify" value="Verify" class="btn btn-default center-block">
							<hr>
							<br>
							<div class="separator">

								<div>
									<h1><i class="fa fa-xing"></i> Xero</h1>
									<p>2017 All Rights Reserved @ Xero Company Limited</p>
								</div>
							</div>
						</div>
					</form>
				<?php elseif(isset($_SESSION['driverauthyes'])): ?>
					<form method="post">
						<div>
							<label for="newpassword">New Password</label>
							<input type="password" name="newpassword" id="newpassword" required pattern=".{8,}" title="8 characters minimum" placeholder="must be at least 8 characters"  class="form-control">
						</div>
						
						<div>
							<label for="confirmpassword">Confirm Password</label>
							<input type="password" name="confirmpassword" id="confirmpassword" required  pattern=".{8,}" title="8 characters minimum" placeholder="must be at least 8 characters" class="form-control">
						</div>

						<div>
							<input type="submit" style="margin-left: 0;"  name="changepassword" value="Change Password" class="btn btn-default center-block">
						</div>
						<hr>
						<br>
						<div class="separator">

							<div>
								<h1><i class="fa fa-xing"></i> Xero</h1>
								<p>2017 All Rights Reserved @ Xero Company Limited</p>
							</div>
						</div>
					</form>

				<?php endif; ?>
				</div>
			</section>
			</div>
			</div>
		</div>

	<!-- jQuery -->
	<script src="../javascripts/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="../javascripts/bootstrap.min.js"></script>
	<!-- SweetAlert -->
	<script src="../javascripts/sweetalert-dev.js"></script>
	<script>
	</script>
	</body>

	<?php
	if (isset($_POST['submit'])):
		$driververifiedcode = rand(111111, 999999);
        $driveremail = $_POST['email'];
        $getdriver = mysql_query("select * from drivers where driveremail = '$driveremail'") or die(mysql_error());
        $checkdriver = mysql_num_rows($getdriver);
        if ($checkdriver < 1) {
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
        	$rowdriver = mysql_fetch_assoc($getdriver);
        	$_SESSION['driverid'] = $rowdriver['driverid'];
			require '../sendemail/phpmailer/PHPMailerAutoload.php';
		    $email = 'xerocarrental@gmail.com';                    
		    $password = 'xerocarrental123';
		    $to_id = $driveremail;
		    $message = 'Your verification code for changing password is '.$driververifiedcode;
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
				$_SESSION['driversentemail'] = true;
				$_SESSION['driververifiedcode'] = $driververifiedcode;
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
		$driververifycode = $_SESSION['driververifiedcode'];
		if ($inputverificationcode != $driververifycode) {
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
			$_SESSION['driverauthyes'] = true;
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
				$driverid = $_SESSION['driverid'];
                $changepasswordsql = mysql_query("UPDATE drivers set driverpassword = '$newpassword' where driverid = '$driverid'") or die(mysql_error());
                session_destroy();
                echo "<script>swal({
                title: 'Success!',
                text: 'Your password is successfully changed! Please Login!',
                type: 'success',
                timer: 1000,
                showConfirmButton: false
                }, function(){
                window.location.href = '../adminlogin.php';
                });</script>";
	        }
	    }

    endif;

	?>
</html>