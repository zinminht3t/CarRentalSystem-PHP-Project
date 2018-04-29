<?php

	//to use session
	session_start();

	//for mysql database connection
	include('dbconfig/dbconfig.php');
	$currentpage = 'index';


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Xero | Home Page</title>

		<!-- Bootstrap -->
		<link href="style/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="fa/css/font-awesome.min.css" rel="stylesheet">
		<!-- Sweet Alert -->
		<link rel="stylesheet" href="style/sweetalert.css">
		<!-- Site Logo -->
		<link href = "images/design/logo.png" rel="icon" type="image/png">
		<!-- Custom Style -->
		<link href="style/customstyle.css" rel="stylesheet">
		<!-- Date Picker -->
		<link href="style/daterangepicker.css" rel="stylesheet">

	</head>

	<body class="onepagebody">

		<?php include '_navigationbar.php'; ?>

		<div class="container">
			<div class="row indexpage">

			<?php if (isset($_SESSION['authentication'])): ?>
				<form action="_firststepbooking.php" method="post">

					<div class="form-group">
						<div class="col-md-5">
						<label for="hirefrom"><i class="fa fa-home"></i> Hire from :</label></div>
						<select name="officeid" id="hirefrom" class="form-control" required="required">
							<?php
								$sqlgetoffice = mysql_query("SELECT * from Offices");
								while ($rowgetoffice = mysql_fetch_assoc($sqlgetoffice)):
							?>
								<option value="<?php echo $rowgetoffice['officeid']; ?>"><?php echo $rowgetoffice['officename']; ?> Office</option>
							<?php	
								endwhile;
							?>
						</select>
					</div>
					
					<div class="form-group">
						<label for="driver"><i class="fa fa-male"></i> Driver :</label>
						<select name="driver" required="required" class="form-control" onchange="SelectDriver(this.value)" id="driver">
							<option value="driver">I want to hire driver!</option>
							<option value="nodriver">No driver!</option>
						</select>
					</div>

					<div class="form-group">
						<input type="text" class="form-control" id="pickuplocation" required="required" placeholder="Pickup Location"  name="pickuplocation">
					</div>

					<div class="form-group">
					<input type="text" class="form-control" id="returnlocation" required="required" placeholder="Return Location"  name="returnlocation">
					</div>

					<div class="form-group">
						<label for=""><i class="fa fa-clock-o"></i> Pick Date and Time Range : </label>
						<input type="text" class="form-control" required="required" name="fromtodatetime" value="<?php echo date('Y-m-d h:i A'); ?> - 01/12/2017 2:00 PM" />
					</div>
					
					<div class="form-group">
					<input type="submit" class="btn btn-success center-block" value="Reserve">
					</div>
				</form>


			<?php else: ?>
				<form action="" method="post">
					<div class="form-group">
						<label for="customerusername"><i class='fa fa-user-circle-o'></i> Username</label>

						<div>
							<input type="text" class="form-control" name="customerusername" required placeholder="Username">
						</div>
					</div>

					<div class="form-group">
						<label for="customerpassword"><i class='fa fa-unlock'></i> Password</label>

						<div>
							<input type="password" class="form-control" name="customerpassword" required placeholder="Password">
						</div>
					</div>

					<div class="form-group">
						<a href="forgetpassword.php" style="color: yellow; text-decoration: none;"><i class="fa fa-question-circle"></i> Forget Password?</a>
					</div>


					<div class="form-group">
						<div class="col-md-3">
						</div>
							<button class="btn btn-success" name="submit"><i class="fa fa-arrow-right"></i> Login</button>
							<a href="register.php"  class="btn btn-primary"><i class="fa fa-plus-circle"></i> Register</a>
					</div>
				</form>
			<?php endif ?>

			</div>
		</div>


	<!-- jQuery -->
	<script src="javascripts/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="javascripts/bootstrap.min.js"></script>
	<!-- SweetAlert -->
	<script src="javascripts/sweetalert-dev.js"></script>
	
	<script type="text/javascript" src="javascripts/moment.min.js"></script>
	<!-- Date Picker -->
	<script src="javascripts/daterangepicker.js"></script>

	<script>
		$(function() {
		    $('input[name="fromtodatetime"]').daterangepicker({
		        timePicker: true,
		        timePickerIncrement: 30,
		        locale: {
		            format: 'YYYY-MM-DD h:mm A'
		        }
		    });
		});

		function SelectDriver(dri) {
			if (dri == 'nodriver') {
				var hirefrom = document.getElementById('hirefrom').options[document.getElementById('hirefrom').selectedIndex].text;
				document.getElementById('pickuplocation').value = hirefrom;
				document.getElementById('pickuplocation').type = "hidden";
				document.getElementById('returnlocation').value = hirefrom;
				document.getElementById('returnlocation').type = "hidden";
			}
			else{
				document.getElementById('pickuplocation').value = "";
				document.getElementById('pickuplocation').type = "text";
				document.getElementById('returnlocation').value = "";
				document.getElementById('returnlocation').type = "text";

			}
		}
	</script>
	</body>

	<?php
		
		if (isset($_POST['submit'])):

			$customerusername = $_POST['customerusername'];
			$customerrawpassword = $_POST['customerpassword'];
			$customerpassword = md5($customerrawpassword);

			$query = mysql_query("SELECT * FROM Customers where customerusername = '$customerusername' AND customerpassword = '$customerpassword' and active = 1") or die(mysql_error());
			$querynumrow = mysql_num_rows($query);

			if($querynumrow > 0)
			{
			    $_SESSION['authentication'] = true;
			    $_SESSION['customerusername'] = $customerusername;
			    $row = mysql_fetch_assoc($query);
			    $customerid = $row['customerid'];
			    $_SESSION['customerid'] = $customerid;
		  		echo "<script>swal({
				  title: 'Success!',
				  text: 'You are now logged in!',
				  type: 'success',
				  timer: 1000,
				  showConfirmButton: false
				}, function(){
				      window.location.href = 'index.php';
				});</script>";
			}
			else{
				$checkban = mysql_query("SELECT * FROM Customers where customerusername = '$customerusername' AND customerpassword = '$customerpassword' and active = 0") or die(mysql_error());
				$checkbanquerynumrow = mysql_num_rows($checkban);
				if ($checkbanquerynumrow > 0) {
					echo "<script>swal({
					title: 'Oops!',
					text: 'Your account has been banned!',
					type: 'error',
					timer: 1000,
					showConfirmButton: false
					}, function(){
					window.location.href = 'index.php';
					});</script>";
				}
				else{
				echo "<script>swal({
				title: 'Oops!',
				text: 'Your username or password is wrong!',
				type: 'error',
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