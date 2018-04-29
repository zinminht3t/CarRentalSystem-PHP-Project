<?php
	session_start();
	include('dbconfig/dbconfig.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Xero | Driver Panel</title>

		<!-- Bootstrap -->
		<link href="style/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="fa/css/font-awesome.min.css" rel="stylesheet">
		<!-- Site Logo -->
		<link href = "images/design/logo.png" rel="icon" type="image/png">
		<!-- Font Awesome -->
		<link href="style/chosen.min.css" rel="stylesheet">
		<!-- Sweet Alert -->
		<link rel="stylesheet" href="style/sweetalert.css">

		<!-- Custom Theme Style -->
		<link href="style/custom.min.css" rel="stylesheet">

	</head>

	<body class="login">
		<div>
			<a class="hiddenanchor" id="signup"></a>
			<a class="hiddenanchor" id="signin"></a>

			<div class="login_wrapper">
			<div class="animate form login_form">
			<section class="login_content">
			<form method="post">
				<h1>Login Form</h1>
				<div>
					<input type="text" class="form-control" placeholder="Username" name="driverusername" />
				</div>
				<div>
					<input type="password" class="form-control" placeholder="Password" name="driverpassword" />
				</div>
				<div>
					<input type="submit" style="margin-left: 0;" name="submit" class="btn btn-default form-control" value="Login">
				</div>
					<a href="driver/forgetpassword.php">Forget Password ?</a><br>
				<hr>
				<br>

				<div class="separator">

					<div>
						<h1><i class="fa fa-xing"></i> Xero</h1>
						<p>2017 All Rights Reserved @ Xero Company Limited</p>
					</div>
				</div>
			</form>
			</section>
			</div>
			</div>
		</div>
		<!-- SweetAlert -->
		<script src="javascripts/sweetalert-dev.js"></script>
		<?php
			if (isset($_POST['submit'])):

				$driverusername = $_POST['driverusername'];
				$rawdriverpassword = $_POST['driverpassword'];
				$driverpassword = md5($rawdriverpassword);

				$sql = mysql_query("SELECT * from drivers where driverusername = '$driverusername' AND driverpassword = '$driverpassword' AND active = 1");
				$rownum = mysql_num_rows($sql);
				if ($rownum > 0) {
					$rowstaff = mysql_fetch_assoc($sql);
					$_SESSION['driverid'] = $rowstaff['driverid'];
					$_SESSION['driverusername'] = $rowstaff['driverusername'];
					$_SESSION['driverauth'] = true;		  		
					echo "<script>swal({
					title: 'Success!',
					text: 'You are now logged in as Driver!',
					type: 'success',
					timer: 1500,
					showConfirmButton: false
					}, function(){
					window.location.href = 'driver/ddashboard.php';
					});</script>";
				}
				else{
					$checkban = mysql_query("SELECT * FROM Drivers where driverusername = '$driverusername' AND driverpassword = '$driverpassword' and active = 0") or die(mysql_error());
					$checkbanquerynumrow = mysql_num_rows($checkban);
					if ($checkbanquerynumrow > 0) {
						echo "<script>swal({
						title: 'Oops!',
						text: 'Your account has been banned!',
						type: 'error',
						timer: 1200,
						showConfirmButton: false
						}, function(){
						window.location.href = 'driverlogin.php';
						});</script>";
					}
					else{
						echo "<script>swal({
						title: 'Oops!',
						text: 'Your username or password is wrong!',
						type: 'error',
						timer: 1200,
						showConfirmButton: false
						}, function(){
						window.location.href = 'driverlogin.php';
						});</script>";
					}
				}
			endif;
			

		?>
	</body>
</html>