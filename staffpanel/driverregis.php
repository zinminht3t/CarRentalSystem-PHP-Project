<?php
	session_start();
	include('../dbconfig/dbconfig.php');
	if (!$_SESSION['managerauth']) {
		echo "<script>window.location='../adminlogin.php'</script>";
	}

	$staffid = $_SESSION['staffid'];
	$username = $_SESSION['staffusername'];

	$getstaffsql = mysql_query("Select * from Staffs where staffid = '$staffid'");
	$rowgetstaff = mysql_fetch_assoc($getstaffsql);
	$staffname = $rowgetstaff['staffname'];

	$officeid = $rowgetstaff['officeid'];
	$staffphoto = $rowgetstaff['staffphoto'];

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Xero - Manager Panel</title>

		<!-- Bootstrap -->
		<link href="../style/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="../fa/css/font-awesome.min.css" rel="stylesheet">
		<!-- Site Logo -->
		<link href = "../images/design/logo.png" rel="icon" type="image/png">

		<!-- Custom Theme Style -->
		<link href="../style/custom.min.css" rel="stylesheet">
		<link href="../style/customstyle.css" rel="stylesheet">
		<!-- Sweet Alert -->
		<link rel="stylesheet" href="../style/sweetalert.css">
	</head>

	<body class="nav-md">
		<div class="container body">
			<div class="main_container">
				<div class="col-md-3 left_col">
					<div class="left_col scroll-view">
						<div class="navbar nav_title" style="border: 0;">
							<a href="mdashboard.php" class="site_title"><i class="fa fa-xing"></i> <span>Xero</span></a>
						</div>

						<div class="clearfix"></div>

						<!-- menu profile quick info -->
						<div class="profile clearfix">
							<div class="profile_pic">
								<img src="../images/staffphoto/<?php echo $staffphoto; ?>" alt="..." class="img-circle profile_img">
							</div>
							<div class="profile_info">
								<span>Welcome,</span>
								<h2><?php echo $staffname; ?></h2>
							</div>
							<div class="clearfix"></div>
						</div>
						<!-- /menu profile quick info -->

						<br />

						<!-- sidebar menu -->
						<?php
							include ('misc/_sidebarmenu.php');
						?>
					</div>
				</div>

				<!-- top navigation -->
						<?php
							include('misc/_navigationbar.php');
						?>
				<!-- /top navigation -->

				<!-- page content -->
				<div class="right_col" role="main">
					<div class="">
						<div class="page-title">
							<div class="title_left">
								<h3>Driver Registration</h3>
							</div>
						</div>

						<div class="clearfix"></div>

						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<form method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="driverid">Driver ID <span class="required">*</span>
										</label>

										<?php
										  	$getlatestid = mysql_query("SELECT driverid FROM Drivers WHERE SUBSTRING(driverid,7) = (SELECT MAX(CAST(SUBSTRING(driverid,7) AS SIGNED)) FROM Drivers)"); 
											$queryrow = mysql_num_rows($getlatestid);

											if ($queryrow < 1):
												$newid = 'driver1';

											else:
												  while ($row = mysql_fetch_assoc($getlatestid)):
												    $lastid =  $row['driverid'];
													$lastid = preg_replace("/[^0-9]/","",$lastid);
												  endwhile;
												  $lastid = $lastid + 1;
												  $newid = 'driver'.$lastid;

											endif;
										?>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="driverid" required="required" readonly value="<?php echo $newid; ?>" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drivername">Driver Name <span class="required">*</span>
										</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="drivername" required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="driveremail">Driver Email <span class="required">*</span>
										</label>
										
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="email" name="driveremail" required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="driverusername">Driver Username <span class="required">*</span>
										</label>
										
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="driverusername" pattern=".{8,}" title="8 characters minimum" placeholder="must be at least 8 characters"  required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="driverpassword">Driver Password <span class="required">*</span>
										</label>
										
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="password" name="driverpassword" pattern=".{8,}" title="8 characters minimum" placeholder="must be at least 8 characters" required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirmpassword">Confirm Password <span class="required">*</span>
										</label>
										
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="password" name="confirmpassword" required="required" pattern=".{8,}" title="8 characters minimum" placeholder="must be at least 8 characters" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="driverexperience">Experience <span class="required">*</span>
										</label>
										
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" placeholder="3 years 4 months" required  name="driverexperience" required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="driverage">Age <span class="required">*</span>
										</label>
										
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" placeholder="22" name="driverage" required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="driverphoto">Driver Photo
										</label>
										
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="file" name="driverphoto" required class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="licensephoto">Licence Photo <span class="required">*</span>
										</label>
										
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="file" name="licensephoto" required class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Gender <span class="required">*</span>
										</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="radio" required value="male" checked name="drivergender"> Male
											<input type="radio" required value="female" name="drivergender"> Female
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="driverstatus">Driver Status <span class="required">*</span>
										</label>
										
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select name="driverstatus" required="required" id="driverstatus" class="form-control col-md-7 col-xs-12">
												<option value="employee">Employee</option>
												<option value="freelance">Freelance</option>
											</select>
										</div>
									</div>


									<div class="form-group">
										<label for="officename" class="control-label col-md-3 col-sm-3 col-xs-12">Office Name <span class="required">*</span></label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<select name="officeid" required class="form-control">
												<?php
													$getofficesql = mysql_query("SELECT officeid, officename from Offices");
													while ($rowgetoffice = mysql_fetch_assoc($getofficesql)) {
												?>
													<option value="<?php echo $rowgetoffice['officeid']; ?>"><?php echo $rowgetoffice['officename']; ?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drivercost">Driver Cost <span class="required">*</span>
										</label>
										
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" placeholder="per day" name="drivercost" required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="ln_solid"></div>

									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
											<input type="submit" name="submit" value="Submit" class="btn btn-success">
											<input type="reset" name="reset" value="Reset" class="btn btn-primary">
											<a href="drivermanagement.php"><button class="btn btn-danger" type="button">Cancel</button></a>
										</div>
									</div>

								</form>

							</div>
						</div>
					</div>
				</div>
				<!-- /page content -->

				<!-- footer content -->
				<footer>
					<div class="pull-right">
						Xero - Online Car Rental by <a href="index.php">Xero</a>
					</div>
					<div class="clearfix"></div>
				</footer>
				<!-- /footer content -->
			</div>
		</div>

		<!-- jQuery -->
		<script src="../javascripts/jquery.min.js"></script>
		<!-- Bootstrap -->
		<script src="../javascripts/bootstrap.min.js"></script>
		<!-- FastClick -->
		<script src="../javascripts/fastclick.js"></script>
		
		<!-- Custom Theme Scripts -->
		<script src="../javascripts/custom.min.js"></script>
		<!-- SweetAlert -->
		<script src="../javascripts/sweetalert-dev.js"></script>

		<script>

			
			
		</script>

		<?php
			
			if (isset($_POST['submit'])):
				$driverid = $_POST['driverid'];
				$drivername = $_POST['drivername'];
				$driverusername = $_POST['driverusername'];
				$rawdriverpassword = $_POST['driverpassword'];
				$confirmpassword = $_POST['confirmpassword'];

				if ($rawdriverpassword != $confirmpassword) {
					echo "<script>swal({
					title: 'Oops!',
					text: 'Passwords do not match!',
					type: 'error',
					timer: 1000,
					showConfirmButton: false
					}, function(){
					window.location.href = 'driverregis.php';
					});</script>";
				}

				$checkusernamesql = mysql_query("select * from drivers where driverusername = '$driverusername'") or die(mysql_error());
				$rownocheckusername = mysql_num_rows($checkusernamesql);

				if ($rownocheckusername > 0) {
					echo "<script>swal({
					title: 'Oops!',
					text: 'Username already taken!',
					type: 'error',
					timer: 1000,
					showConfirmButton: false
					}, function(){
					window.location.href = 'driverregis.php';
					});</script>";
				}
				else{
					$driverpassword = md5($rawdriverpassword);
					$officeid = $_POST['officeid'];
					$drivercost = $_POST['drivercost'];
					$drivergender = $_POST['drivergender'];
					$driveremail = $_POST['driveremail'];
					$driverstatus = $_POST['driverstatus'];

					$driverexperience = $_POST['driverexperience'];
					$driverage = $_POST['driverage'];
	  
					$driverphoto = $_FILES['driverphoto']['name'];
					$tmp = $_FILES['driverphoto']['tmp_name'];
	  
					$licensephoto = $_FILES['licensephoto']['name'];
					$tmp = $_FILES['licensephoto']['tmp_name'];

					if($driverphoto) {
						$allowfiletype =  array('GIF','PNG' ,'JPG', 'gif', 'png', 'jpg');
						$ext = end((explode(".", $driverphoto)));
						if(!in_array($ext, $allowfiletype) ) {
						    echo "<script>swal({
						    title: 'Oops!',
						    text: 'Only Image Files (gif, png, jpg) are allowed!',
						    type: 'error',
						    timer: 1000,
						    showConfirmButton: false
						    }, function(){
						    window.location.href = 'caredit.php';
						    });</script>";
						}
						else{
							move_uploaded_file($tmp, "../images/driverphoto/$driverphoto");
						}
					}

					if($licensephoto) {
						$allowfiletype =  array('GIF','PNG' ,'JPG', 'gif', 'png', 'jpg');
						$ext = end((explode(".", $licensephoto)));
						if(!in_array($ext, $allowfiletype) ) {
						    echo "<script>swal({
						    title: 'Oops!',
						    text: 'Only Image Files (gif, png, jpg) are allowed!',
						    type: 'error',
						    timer: 1000,
						    showConfirmButton: false
						    }, function(){
						    window.location.href = 'driverregis.php';
						    });</script>";
						}
						else{
							move_uploaded_file($tmp, "../images/licensephoto/$licensephoto");
							mysql_query("Insert into Drivers values('$driverid', '$drivername', '$driverusername', '$driverpassword', '$driverage', '5', '$driverstatus', '$officeid', '$drivercost', '$drivergender', '$driverphoto','$driveremail', '$licensephoto', '$driverexperience', now(), '')")
			   				 or die(mysql_error());
			   				 echo "<script>swal({
			   				 title: 'Success!',
			   				 text: 'New Driver has been saved!',
			   				 type: 'success',
			   				 timer: 1000,
			   				 showConfirmButton: false
			   				 }, function(){
			   				 window.location.href = 'drivermanagement.php';
			   				 });</script>";
						}
					}
	   			}
			endif;
		?>
	</body>
</html>
