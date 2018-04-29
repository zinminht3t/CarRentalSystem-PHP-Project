<?php

	//to use session
	session_start();

	//for mysql database connection
	include('dbconfig/dbconfig.php');

	if (!isset($_SESSION['secondbooking'])) {
		echo "<script>window.location.href = 'index.php';</script>";
	}

	$carid = $_SESSION['carid'];
	$durationinhours = $_SESSION['durationinhours'];
	$driver = $_SESSION['driver'];

	$getcarsql = mysql_query("SELECT c.*, oc.carid FROM Cars c, OfficeCars oc
												WHERE c.carno = oc.carno
												AND oc.carid = '$carid'") or die(mysql_error());
	$rowgetcar = mysql_fetch_assoc($getcarsql);

	$carcost = $rowgetcar['carcost']/6 * $durationinhours;
	$_SESSION['carcost'] = $carcost;

	if ($driver == 'nodriver') {
		$drivercost = 0;
		$_SESSION['drivercost'] = 0;
	}
	else{
		$driverid = $_SESSION['driverid'];
		$getdriversql = mysql_query("SELECT * FROM Drivers where driverid = '$driverid'") or die(mysql_error());
		$rowgetdriver = mysql_fetch_assoc($getdriversql);
		$drivercost = $rowgetdriver['drivercost']/24 * $durationinhours;
		$_SESSION['drivercost'] = $drivercost;
	}



	$customerusername = $_SESSION['customerusername'];
	$getcustomer = mysql_query("SELECT * FROM Customers where customerusername = '$customerusername'");
	$rowgetcustomer = mysql_fetch_assoc($getcustomer);

	$customerid = $rowgetcustomer['customerid'];
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

		<title>Xero | Final Booking</title>

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

				<div class="col-md-8 booking-detail">
						<div class="col-md-4 col-sm-4 col-xs-12 profile_left">
							<h4>Booking Detail</h4>

							<ul class="list-unstyled user_data">
								<li><i class="fa fa-home user-profile-icon"></i> Pickup from <?php echo $_SESSION['pickuplocation']; ?>
								</li>

								<li>
									<i class="fa fa-map-marker user-profile-icon"></i> Return to <?php echo $_SESSION['returnlocation']; ?>
								</li>

								<li><i class="fa fa-clock-o user-profile-icon"></i> From <?php echo $_SESSION['pickuptime']; ?>
								</li>
								
								<li><i class="fa fa-clock-o user-profile-icon"></i> to <?php echo $_SESSION['returntime']; ?>
								</li>
							</ul>

							<?php
							if ($driver == 'nodriver'): ?>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12 profile_left">
							<?php endif; ?>
							
							<h4>Customer Detail</h4>
							<div class="profile_img">
								<div id="crop-avatar">
								<!-- Current avatar -->
									<img class="img-circle avatar-view" width="200px" height="200px" src="images/customerphoto/<?php echo $rowgetcustomer['customerphoto']; ?>" alt="Avatar">
								</div>
							</div>
							<h4><?php echo $rowgetcustomer['customername']; ?></h4>

							<ul class="list-unstyled user_data">
								<li><i class="fa fa-user-circle-o user-profile-icon"></i> <?php echo $rowgetcustomer['customerusername']; ?>
								</li>

								<li>
								<i class="fa fa-envelope user-profile-icon"></i> <?php echo $rowgetcustomer['customeremail']; ?>
								</li>

								<li>
								<i class="fa fa-male user-profile-icon"></i> <?php echo $rowgetcustomer['customergender']; ?>
								</li>

								<li>
								<i class="fa fa-calendar user-profile-icon"></i> <?php echo $rowgetcustomer['customerdob']; ?>
								</li>
							</ul>

							<?php
							if ($driver == 'nodriver'): ?>
								</div>
								<div>
							<?php endif; ?>

						</div>

						<div class="col-md-4 col-sm-4 col-xs-12 profile_left">
							<h4 align="center">Car Detail</h4>
							<div class="profile_img">
								<div id="crop-avatar">
								<!-- Current avatar -->
									<img class="img-responsive img-circle avatar-view" src="images/carphoto/<?php echo $rowgetcar['carphoto']; ?>" alt="Avatar">
								</div>
							</div>
							<h4><?php echo $rowgetcar['carname']; ?></h4>

							<ul class="list-unstyled user_data">
								<li><i class="fa fa-car user-profile-icon"></i> <?php echo $rowgetcar['carname']; ?>
								</li>

								<li>
									<i class="fa fa-bus user-profile-icon"></i> <?php echo $rowgetcar['carclass']; ?>
								</li>

								<li><i class="fa fa-cog user-profile-icon"></i> <?php echo $rowgetcar['cartransmission']; ?>
								</li>
								
								<li><i class="fa fa-car user-profile-icon"></i> <?php echo $rowgetcar['cartype']; ?>
								</li>
								
								<li id="passengerqty"><i class="fa fa-users user-profile-icon"></i> <?php echo $rowgetcar['carcapacity']; ?> Persons
								</li>
								
								<li><i class="fa fa-bolt user-profile-icon"></i> <?php echo $rowgetcar['carairbag']; ?>
								</li>
								
								<li><i class="fa fa-info user-profile-icon"></i> <?php echo $rowgetcar['carotherdescription']; ?>
								</li>
							</ul>
						</div>


						<?php

							if ($driver == 'nodriver'):
								$_SESSION['driverid'] = 'nodriver';
							else:

						?>
						<div class="col-md-4 col-sm-4 col-xs-12 profile_left">
								<h4 align="center">Driver Detail</h4>
								<div class="profile_img">
									<div id="crop-avatar">
									<!-- Current avatar -->
										<img class="img-responsive img-circle avatar-view" src="images/driverphoto/<?php echo $rowgetdriver['driverphoto']; ?>" alt="Avatar">
									</div>
								</div>
								<h4><?php echo $rowgetdriver['drivername']; ?></h4>

								<ul class="list-unstyled user_data">
									<li><i class="fa fa-user-circle-o user-profile-icon"></i> <?php echo $rowgetdriver['driverusername']; ?>
									</li>

									<li>
									<i class="fa fa-envelope user-profile-icon"></i> <?php echo $rowgetdriver['driveremail']; ?>
									</li>

									<li>
									<i class="fa fa-male user-profile-icon"></i> <?php echo $rowgetdriver['drivergender']; ?>
									</li>

									<li>
									<i class="fa fa-drivers-license-o user-profile-icon"></i> <?php echo $rowgetdriver['driverstatus']; ?>
									</li>

									<li>
									<i class="fa fa-money user-profile-icon"></i> <?php echo $rowgetdriver['drivercost']; ?> per Hour
									</li>

									<li>
									<i class="fa fa-star user-profile-icon"></i> <?php echo $rowgetdriver['driverrating']; ?> Stars
									</li>
								</ul>
						</div>
						<?php
							endif;
						?>
					
				</div>

				<div class="col-md-3 col-md-offset-1 calculate-fees">
					<h3>Fees</h3><hr>
					<ul class="list-unstyled user_data" style="text-align: center; font-size: 1.2em; color: #efc;">
						<li><i class="fa fa-car"></i> Car Cost : $<?php echo $carcost; ?></li><hr>
						<li><i class="fa fa-male"></i> Driver Cost : $<?php echo $drivercost; ?></li><hr>
						<li><i class="fa fa-clock-o"></i> Duration in Hours : <?php echo $durationinhours; ?></li>
						<hr>
						<li><i class="fa fa-credit-card"></i> Total Cost : $<?php echo $totalcost = $carcost + $drivercost; $_SESSION['totalcost'] = $totalcost; ?></li><hr>
					</ul>
					Pay with
					<form method="post">
						<div class="form-group">
							<input type="radio" name="payment" required="required" id="paypal" onclick="selectpayment(this.value)" value="paypal"> <label for="paypal"><i class="fa fa-paypal"></i> Paypal</label>
							<input type="radio" name="payment" required="required" onclick="selectpayment(this.value)" value="incash" id="incash"> <label for="incash"><i class="fa fa-money"></i> Pay at Arrival</label>
						</div>

						<div class="form-group">
							<input type="hidden" class="form-control" required="" id="paypalemail" placeholder="Paypal Email"  name="paypalemail">
						</div>
						<div class="form-group">
							<input type="hidden" class="form-control" required="" id="paypalpassword" placeholder="Paypal Password"  name="paypalpassword">
						</div>

						<div class="form-group">
							<button class="btn btn-primary center-block" name="submit"><i class="fa fa-check"></i> Confirm Reservation</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	<?php
	?>
			
	</body>

	<!-- jQuery -->
	<script src="javascripts/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="javascripts/bootstrap.min.js"></script>
	<!-- SweetAlert -->
	<script src="javascripts/sweetalert-dev.js"></script>
	<script>
		function selectpayment(paymentmethod) {
			if (paymentmethod == 'paypal') {
				document.getElementById('paypalemail').type = "email";
				document.getElementById('paypalemail').required = "required";
				document.getElementById('paypalpassword').type = "password";
				document.getElementById('paypalpassword').required = "required";
			}
			else if (paymentmethod == 'mastercard'){
				document.getElementById('paypalemail').type = "hidden";
				document.getElementById('paypalemail').required = "";
				document.getElementById('paypalpassword').type = "hidden";
				document.getElementById('paypalpassword').required = "";
			}
			else{
				document.getElementById('paypalemail').type = "hidden";
				document.getElementById('paypalemail').required = "";
				document.getElementById('paypalpassword').type = "hidden";
				document.getElementById('paypalpassword').required = "";

			}
		}
	</script>


						<?php

						if (isset($_POST['submit'])):

						function Order($paymentmethod){
						  	$getlatestid = mysql_query("SELECT bookingid FROM Bookings WHERE SUBSTRING(bookingid,8) = (SELECT MAX(CAST(SUBSTRING(bookingid,8) AS SIGNED)) FROM Bookings)"); 
							$queryrow = mysql_num_rows($getlatestid);

							if ($queryrow < 1){
								$bookingid = 'booking1';
							}

							else{
								  while ($row = mysql_fetch_assoc($getlatestid)):
								    $lastid =  $row['bookingid'];
									$lastid = preg_replace("/[^0-9]/","",$lastid);
								  endwhile;
								  $lastid = $lastid + 1;
								  $bookingid = 'booking'.$lastid;
							}
							$officeid = $_SESSION['officeid'];
							$customerid = $_SESSION['customerid'];
							$durationinhours = $_SESSION['durationinhours'];
							$carcost = $_SESSION['carcost'];
							$drivercost = $_SESSION['drivercost'];
							$totalcost = $_SESSION['totalcost'];
							$carid = $_SESSION['carid'];
							$driverid = $_SESSION['driverid'];
							$pickuptime = $_SESSION['pickuptime'];
							$returntime = $_SESSION['returntime'];
							$pickuplocation = $_SESSION['pickuplocation'];
							$returnlocation = $_SESSION['returnlocation'];
							$reservesql = mysql_query("insert into Bookings(bookingid, customerid, officeid, pickuptime, returntime, pickuplocation, returnlocation, durationinhours, carid, carcost, driverid, drivercost, totalcost, paymentmethod, bookingtime) VALUES ('$bookingid', '$customerid', '$officeid', '$pickuptime', '$returntime', '$pickuplocation', '$returnlocation', '$durationinhours', '$carid', '$carcost', '$driverid', '$drivercost', '$totalcost', '$paymentmethod', now())") or die(mysql_error());

							$except =  array('customerusername','customerid' ,'authentication');
							foreach ($_SESSION as $key => $value)
							{
								if (!in_array($key, $except))
								{
								unset($_SESSION[$key]);
								}
							}

					  		echo "<script>swal({
							  title: 'Success!',
							  text: 'Your Reservation has been recorded! Please wait for admin approvement by email!',
							  type: 'success',
							  timer: 1500,
							  showConfirmButton: false
							}, function(){
							      window.location.href = 'reservation.php';
							});</script>";

						}

						$paymentmethod = $_POST['payment'];

						if ($paymentmethod == 'paypal') {
							$paypalemail = $_POST['paypalemail'];
							$paypalpassword = $_POST['paypalpassword'];
							$paypalpassword = md5($paypalpassword);

							$verifypaypal = mysql_query("SELECT * FROM PayPalServer where customerid = '$customerid' AND paypalemail = '$paypalemail' and paypalpassword = '$paypalpassword'") or die(mysql_error());
							$rownoverifypaypal = mysql_num_rows($verifypaypal);
							if ($rownoverifypaypal > 0) {
								$rowverifypaypal = mysql_fetch_assoc($verifypaypal);
								$balance = $rowverifypaypal['balance'];
								if ($balance < $totalcost) {
							  		echo "<script>swal({
									  title: 'Oops!',
									  text: 'Your PayPal Balance is low! Cannot Purchase!',
									  type: 'error',
									  timer: 1500,
									  showConfirmButton: false
									}, function(){
									      window.location.href = 'finalbooking.php';
									});</script>";
									
								}
								else{
									$changepaypalbalance = mysql_query("update PayPalServer set balance = balance - $totalcost where customerid = '$customerid'") or die(mysql_error());
									Order('paypal');
								}
							}
							else {
						  		echo "<script>swal({
								  title: 'Oops!',
								  text: 'Your PayPal Email or Password is wrong!',
								  type: 'error',
								  timer: 1500,
								  showConfirmButton: false
								}, function(){
								      window.location.href = 'finalbooking.php';
								});</script>";
							}

						}
						else{
							Order('Pay at Arrival');
						}



						endif;


						?>
</html>