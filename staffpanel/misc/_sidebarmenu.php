<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	<div class="menu_section">
		<h3>General</h3>
		<?php
			$staffrole = $_SESSION['staffrole'];
			if ($staffrole == 'branchmanager'):
		?>
		<ul class="nav side-menu">
			<li><a href="mdashboard.php"><i class="fa fa-home"></i> Dashboard</a>
			<li><a href="feedbacks.php"><i class="fa fa-inbox"></i> Feedbacks</a>
			</li>
			<li><a><i class="fa fa-edit"></i> Registrations <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li><a href="driverregis.php">Driver Registration</a></li>
					<li><a href="addnewcartooffice.php">Add New Car to Office</a></li>
					<li><a href="carregis.php">Car Registration</a></li>
					<li><a href="staffregis.php">Staff Registration</a></li>
				</ul>
			</li>
			<li><a><i class="fa fa-desktop"></i> Management <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li><a href="bookingmanagement.php">Booking Management</a></li>
					<li><a href="customermanagement.php">Customer Management</a></li>
					<li><a href="drivermanagement.php">Driver Management</a></li>
					<li><a href="carmanagement.php">Car Management</a></li>
					<li><a href="staffmanagement.php">Staff Management</a></li>
				</ul>
			</li>
			<li><a><i class="fa fa-bar-chart-o"></i> Reports <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li><a href="dailycustomersingupreport.php">Daily New Singup Report</a></li>
					<li><a href="monthlydriverreport.php">Monthly Most Demand Driver Report</a></li>
					<li><a href="monthlycustomerreport.php">Monthly Regular Customer Report</a></li>
					<li><a href="yearlycarreport.php">Yearly Most Demand Vehicle Report</a></li>
				</ul>
			</li>
		</ul>
		<?php
			else:
		?>
		<ul class="nav side-menu">
			<li><a href="sdashboard.php"><i class="fa fa-home"></i> Dashboard</a>
			<li><a href="feedbacks.php"><i class="fa fa-inbox"></i> Feedbacks</a>
			</li>
			<li><a><i class="fa fa-desktop"></i> Management <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li><a href="bookingmanagement.php">Booking Management</a></li>
				</ul>
			</li>
		</ul>
		<?php endif; ?>
	</div>

</div>
