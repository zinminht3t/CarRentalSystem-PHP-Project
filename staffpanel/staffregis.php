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

		<title>Xero - Staff Registration</title>

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
								<h3>Staff Registration</h3>
							</div>
						</div>

						<div class="clearfix"></div>

						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<form method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">

									<div class="form-group">

										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="staffid">Staff ID <span class="required">*</span>
										</label>

										<?php
										  	$getlatestid = mysql_query("SELECT staffid FROM Staffs WHERE SUBSTRING(staffid,6) = (SELECT MAX(CAST(SUBSTRING(staffid,6) AS SIGNED)) FROM Staffs)"); 
											$queryrow = mysql_num_rows($getlatestid);

											if ($queryrow < 1):
												$newid = 'staff1';

											else:
												  while ($row = mysql_fetch_assoc($getlatestid)):
												    $lastid =  $row['staffid'];
													$lastid = preg_replace("/[^0-9]/","",$lastid);
												  endwhile;
												  $lastid = $lastid + 1;
												  $newid = 'staff'.$lastid;

											endif;
										?>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="staffid" required="required" readonly value="<?php echo $newid; ?>" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">

										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="staffname">Staff Name <span class="required">*</span>
										</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="staffname" required="required" class="form-control col-md-7 col-xs-12">
										</div>

									</div>

									<div class="form-group">
										<label for="staffusername" class="control-label col-md-3 col-sm-3 col-xs-12">Staff Username</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" pattern=".{8,}" title="8 characters minimum" placeholder="must be at least 8 characters" name="staffusername" required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label for="staffemail" class="control-label col-md-3 col-sm-3 col-xs-12">Staff Email</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="email" name="staffemail" required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Gender
										</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="radio" value="male" checked name="staffgender"> Male
											<input type="radio" value="female" name="staffgender"> Female
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label for="staffpassword" class="control-label col-md-3 col-sm-3 col-xs-12">Staff Password</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="password" pattern=".{8,}" title="8 characters minimum" placeholder="must be at least 8 characters" name="staffpassword" required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label for="confirmpassword" class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="password" pattern=".{8,}" title="8 characters minimum" placeholder="must be at least 8 characters" name="confirmpassword" required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="staffphoto">Staff Photo
										</label>
										
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="file" name="staffphoto" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="officeid">Office
										</label>
										
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select name="officeid" class="form-control col-md-7 col-xs-12" required>
												<?php
												$getoffices = mysql_query("select * from offices") or die(mysql_error());
												while ($rowoffices = mysql_fetch_assoc($getoffices)):
												?>
												<option value="<?php echo $rowoffices['officeid']; ?>"><?php echo $rowoffices['officename']; ?></option>
												<?php endwhile; ?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Staff Role
										</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="radio" value="staff" checked name="staffrole"> Staff
											<input type="radio" value="branchmanager" name="staffrole"> Branch Manager
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12">
										</div>
									</div>

									<div class="ln_solid"></div>

									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
											<input type="submit" name="submit" value="Submit" class="btn btn-success">
											<input type="reset" name="reset" value="Reset" class="btn btn-primary">
											<a href="stattmanagement.php"><button class="btn btn-danger" type="button">Cancel</button></a>
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
				$staffid = $_POST['staffid'];
				$staffname = $_POST['staffname'];
				$staffusername = $_POST['staffusername'];
				$staffemail = $_POST['staffemail'];
				$staffgender = $_POST['staffgender'];
				$staffrole = $_POST['staffrole'];
				$officeid = $_POST['officeid'];
				$staffgender = $_POST['staffgender'];
				$rawstaffpassword = $_POST['staffpassword'];
				$confirmpassword = $_POST['confirmpassword'];
				if ($rawstaffpassword != $confirmpassword) {
					echo "<script>swal({
					title: 'Oops!',
					text: 'Passwords do not match!',
					type: 'error',
					timer: 1000,
					showConfirmButton: false
					}, function(){
					window.location.href = 'staffregis.php';
					});</script>";
				}

				$checkusernamesql = mysql_query("select * from staffs where staffusername = '$staffusername'") or die(mysql_error());
				$rownocheckusername = mysql_num_rows($checkusernamesql);

				if ($rownocheckusername > 0) {
					echo "<script>swal({
					title: 'Oops!',
					text: 'Username already taken!',
					type: 'error',
					timer: 1000,
					showConfirmButton: false
					}, function(){
					window.location.href = 'staffregis.php';
					});</script>";
				}

				$checkemailsql = mysql_query("select * from staffs where staffemail = '$staffemail'") or die(mysql_error());
				$rownocheckemail = mysql_num_rows($checkemailsql);

				if ($rownocheckemail > 0) {
					echo "<script>swal({
					title: 'Oops!',
					text: 'Email already taken!',
					type: 'error',
					timer: 1000,
					showConfirmButton: false
					}, function(){
					window.location.href = 'staffregis.php';
					});</script>";
				}

				else{

					$staffpassword = md5($rawstaffpassword);
	  
					$staffphoto = $_FILES['staffphoto']['name'];
					$tmp = $_FILES['staffphoto']['tmp_name'];

					if($staffphoto) {
						$allowfiletype =  array('GIF','PNG' ,'JPG', 'gif', 'png', 'jpg');
						$ext = end((explode(".", $staffphoto)));
						if(!in_array($ext, $allowfiletype) ) {
						    echo "<script>swal({
						    title: 'Oops!',
						    text: 'Only Image Files (gif, png, jpg) are allowed!',
						    type: 'error',
						    timer: 1000,
						    showConfirmButton: false
						    }, function(){
						    window.location.href = 'staffregis.php';
						    });</script>";
						}
						else{
						move_uploaded_file($tmp, "../images/staffphoto/$staffphoto");
						mysql_query("Insert into Staffs values('$staffid', '$staffname', '$staffusername', '$staffemail', '$staffpassword', '$staffrole', '$staffphoto', '$officeid', '$staffgender', '', 1)");
						echo "<script>swal({
						title: 'Success!',
						text: 'New Staff Information has been saved!',
						type: 'success',
						timer: 1000,
						showConfirmButton: false
						}, function(){
						window.location.href = 'staffregis.php';
						});</script>";
						}
					}
					else{
						mysql_query("Insert into Staffs values('$staffid', '$staffname', '$staffusername', '$staffemail', '$staffpassword', '$staffrole', '$staffphoto', '$officeid', '$staffgender', '', 1)");
						echo "<script>swal({
						title: 'Success!',
						text: 'New Staff Information has been saved!',
						type: 'success',
						timer: 1000,
						showConfirmButton: false
						}, function(){
						window.location.href = 'staffregis.php';
						});</script>";
						
					}
				}
			endif;
		?>
	</body>
</html>
