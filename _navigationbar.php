<nav id="nav" class="navbar navbarr navbar-default navbar-fixed-top">
	<div class="container navcontainer">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php">
				<i class="fa fa-xing" style="color:#CCFFCC;"> <span style="color:#CCFFCC;">Xero</span></i>
			</a>
		</div>

		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav" id="naviga">
				<li <?php if ($currentpage=="contact") echo " id=\"active\""; ?>><a href="contact.php"><i class="fa fa-globe"></i> Contact</a></li>
				<li<?php if ($currentpage=="faq") echo " id=\"active\""; ?>><a href="faq.pdf"><i class="fa fa-question"></i> FAQ</a></li>
				</li>
			</ul>

			<ul class="nav navbar-nav navbar-right" id="naviga">
			<?php 
			if (isset($_SESSION['authentication'])):
				$customerusername = $_SESSION['customerusername'];
				$getcustomer = mysql_query("select * from Customers where customerusername = '$customerusername'") or die(mysql_error());
				$rowgetcustomer = mysql_fetch_assoc($getcustomer);
				$customerphoto = $rowgetcustomer['customerphoto'];
				$customerid = $rowgetcustomer['customerid'];
			?>
				<li<?php if ($currentpage=="index") echo " id=\"active\""; ?>><a href="index.php"><i class="fa fa-xing"></i> Home</a></li>
				<li<?php if ($currentpage=="cars") echo " id=\"active\""; ?>><a href="cars.php"><i class="fa fa-car"></i> Cars</a></li>
				<li<?php if ($currentpage=="drivers") echo " id=\"active\""; ?>><a href="drivers.php"><i class="fa fa-male"></i> Drivers</a></li>
				<li<?php if ($currentpage=="reservation") echo " id=\"active\""; ?>><a href="reservation.php"><i class="fa fa-info"></i> Reservation</a></li>
				<li class="dropdown" id="navili">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="images/customerphoto/<?php echo $customerphoto; ?>" width="20px" height="20px;" alt="..." class="img-circle profile_img"> <?php echo $customerusername; ?> <span class="caret"></span></a>
					
					<ul class="dropdown-menu">
						<li><a href="profile.php"><i class="fa fa-file"></i>  My Profile</a></li>
						<li><a href="password.php"><i class="fa fa-key"></i> Change Password</a></li>
						<li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
					</ul>
				</li>
			<?php else: ?>
				<li<?php if ($currentpage=="index") echo " id=\"active\""; ?>><a href="index.php"><i class="fa fa-xing"></i> Home</a></li>
				<li<?php if ($currentpage=="register") echo " id=\"active\""; ?>><a href="register.php"><i class="fa fa-plus-circle"></i> Register</a></li>
			<?php endif ?>
			</ul>
		</div>
	</div>
</nav>