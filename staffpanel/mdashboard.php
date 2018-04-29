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
            <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-caret-square-o-right" style="color: #26B99A;"></i></div>
                  <?php
                  $totalbookingsql = mysql_query("select count(bookingid) as countbooking from bookings where month(bookingtime) = month(now())") or die(mysql_error());
                  $totalbookingnumrow = mysql_num_rows($totalbookingsql);
                  if ($totalbookingnumrow < 0) {
                  	$newbooking = 0;
                  }
                  else {
	                  $countrow = mysql_fetch_assoc($totalbookingsql);
	                  $newbooking = $countrow['countbooking'];
                  }
                  ?>
                  <div class="count"><?php echo $newbooking; ?></div>
                  <h3>New Bookings</h3>
                  <p>You have <?php echo $newbooking; ?> bookings in this month!</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-comments-o" style="color: #E95E4F;"></i></div>
                  <?php
                  $totalcarratingsql = mysql_query("select count(carno) as countcarrating from carratings where month(ratingtime) = month(now())") or die(mysql_error());
                  $totalcarratingnumrow = mysql_num_rows($totalcarratingsql);
                  if ($totalcarratingnumrow < 0) {
                  	$newcarrating = 0;
                  }
                  else {
	                  $countrow = mysql_fetch_assoc($totalcarratingsql);
	                  $newcarrating = $countrow['countcarrating'];
                  }
                  ?>
                  <div class="count"><?php echo $newcarrating; ?></div>
                  <h3>New Car Reviews</h3>
                  <p>You have <?php echo $newcarrating; ?> car reviews in this month!</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-sort-amount-asc" style="color: #9B59B6;"></i></div>
                  <div class="count" id="newnoti"><?php echo $noti; ?></div>
                  <h3>New Notifications</h3>
                  <p>You have new nofications!</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-check-square-o" style="color: #F7C7C2;"></i></div>
                  <?php
                  $totalsignupsql = mysql_query("select count(customerid) as countsignup from customers where month(signuptime) = month(now())") or die(mysql_error());
                  $totalsignupnumrow = mysql_num_rows($totalsignupsql);
                  if ($totalsignupnumrow < 0) {
                  	$newsignup = 0;
                  }
                  else {
	                  $countrow = mysql_fetch_assoc($totalsignupsql);
	                  $newsignup = $countrow['countsignup'];
                  }
                  ?>
                  <div class="count" id="newsignup"><?php echo $newsignup; ?></div>
                  <h3>New Sign ups</h3>
                  <p>New Customers in this month!</p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Weekly Summary <small>Activity shares</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div class="row" style="border-bottom: 1px solid #E0E0E0; padding-bottom: 5px; margin-bottom: 5px;">
                      <div class="col-md-7" style="overflow:hidden;">
                          <a href="dailycustomersingupreport.php"><img src="../images/design/booking.png" height="130" style="display: inline-block;"></a>
                        <h4 style="margin:18px">Daily Singup Reports</h4>
                      </div>

                      <div class="col-md-5">
                        <div class="row" style="text-align: center;">
                          <div class="col-md-4">
	                          <a href="monthlycustomerreport.php"><img src="../images/design/1.png" height="110" style="margin: 5px 10px 10px 0" alt=""></a>
                            <h4 style="margin:0">Customer Report</h4>
                          </div>
                          <div class="col-md-4">
	                          <a href="monthlydriverreport.php"><img src="../images/design/2.png" height="110" style="margin: 5px 10px 10px 0" alt=""></a>
                            <h4 style="margin:0">Driver Report</h4>
                          </div>
                          <div class="col-md-4">
	                          <a href="yearlycarreport.php"><img src="../images/design/3.png" height="110" style="margin: 5px 10px 10px 0" alt=""></a>
                            <h4 style="margin:0">Vehicle Report</h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
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
	</body>
</html>
