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

		<title>Xero - Add Car</title>

		<!-- Bootstrap -->
		<link href="../style/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="../fa/css/font-awesome.min.css" rel="stylesheet">
		<!-- Site Logo -->
		<link href = "../images/design/logo.png" rel="icon" type="image/png">
		<!-- Font Awesome -->
		<link href="../style/chosen.min.css" rel="stylesheet">

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
								<h3>Add New Car to Office</h3>
							</div>
						</div>

						<div class="clearfix"></div>

						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<form method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="officeid">Office
										</label>
										
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" readonly value="<?php echo $officeid; ?>" name="officeid" class="form-control col-md-7 col-xs-12">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="carname">Choose Car Name<span class="required" style="height: 20px;">*</span>
										</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<select name="carname" id="carname" required="required" class="chosen-single form-control col-md-7 col-xs-12">
												<?php
													$getcarsql = mysql_query("SELECT * FROM Cars");
													while ($rowgetcar = mysql_fetch_assoc($getcarsql)){
												?>

													<option value="<?php echo $rowgetcar['carno']; ?>"><?php echo $rowgetcar['carname']; ?></option>

												<?php
													}
												?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label for="qty" class="control-label col-md-3 col-sm-3 col-xs-12">Car Qty</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<select name="qty" class="form-control">
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
											</select>
										</div>
									</div>

									<div class="ln_solid"></div>

									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
											<input type="submit" name="submit" value="Submit" class="btn btn-success">
											<input type="reset" name="reset" value="Reset" class="btn btn-primary">
											<a href="carmanagement.php"><button class="btn btn-danger" type="button">Cancel</button></a>
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
		<!-- FastClick -->
		<script src="../javascripts/chosen.jquery.min.js"></script>
		<!-- Custom Theme Scripts -->
		<script src="../javascripts/custom.min.js"></script>
		<!-- SweetAlert -->
		<script src="../../javascripts/sweetalert-dev.js"></script>

		<script>
			$("#carname").chosen({
				no_results_text: "This Car has not been registered! <a href='carregis.php'>Register</a>"
			});
		</script>

		<?php
			
			if (isset($_POST['submit'])):
				$qty = $_POST['qty'];
				$officeid = $_POST['officeid'];
				$carno = $_POST['carname'];
				$getlatestid = mysql_query("SELECT carid FROM OfficeCars WHERE SUBSTRING(carid,6) = (SELECT MAX(CAST(SUBSTRING(carid,6) AS SIGNED)) FROM OfficeCars)"); 
				$queryrow = mysql_num_rows($getlatestid);

				if ($queryrow < 1){
					$newid = 'carid1';
				}
				else{
					  while ($row = mysql_fetch_assoc($getlatestid)):
					    $lastid =  $row['carid'];
						$lastid = preg_replace("/[^0-9]/","",$lastid);
					  endwhile;
					  $lastid = $lastid + 1;
					  $newid = 'carid'.$lastid;
				}

				for ($i=0; $i < $qty; $i++) { 
					$newid = preg_replace("/[^0-9]/","",$newid);
				  	$newid = $newid + $i;
					$newid = 'carid'.$newid;


					$sql ="Insert into OfficeCars(officeid, carid, carno) values('$officeid', '$newid', '$carno')";
				  	//echo "<script>alert('$newid sql');</script>";
					mysql_query($sql);
				}
			echo "<script>window.location='carmanagement.php'</script>";
			endif;
		?>
	</body>
</html>
