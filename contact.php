<?php

	//to use session
	session_start();

	//for mysql database connection
	include('dbconfig/dbconfig.php');
	$currentpage = 'contact';


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Xero | Contact Us</title>

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

	</head>

	<body class="onepagebody">

		<?php include '_navigationbar.php'; ?>

	<div id="contactform">
		<form method="post">
			<div class="form-group">
				<label for="name"><i class="fa fa-user"></i> Name</label>
				<input type="text" name="name" required class="form-control">
			</div>

			<div class="form-group">
				<label for="email"><i class="fa fa-envelope"></i> Email</label>
				<input type="email" name="email" required class="form-control">
			</div>

			<div class="form-group">
				<label for="suggestion"><i class="fa fa-comment"></i> Comment</label>
				<textarea name="suggestion" id="comment" class="form-control" required cols="30" rows="3"></textarea>
			</div>

			<div class="form-group">
				<input type="submit" class="btn btn-primary center-block" name="submit" value="Send">
			</div>
		</form>
	</div>
	<div id="officelocation">
		<?php
			$sql = mysql_query("SELECT * FROM offices");
			while ($row = mysql_fetch_assoc($sql)):
				if ($row['officename'] == 'Mandalay') {
					$default = 'default';
					$office = "Head Office (Mandalay)";
				}
				else{
					$office = $row['officename']." Office";
					$default = '';
				}
		?>
		<div class="box" id="<?php echo $default ?>">
			<h3><i class="fa fa-home"></i> <?php echo $office; ?></h3>
			<ul>
				<li><span style="color: yellow;"><i class="fa fa-location-arrow"></i> Address :</span> <em><?php echo $row['officeaddress'] ?></em></li>
				<?php
					$officeid = $row['officeid'];
					$sqlofficephone = mysql_query("SELECT * FROM officephones WHERE officeid = '$officeid'");
				?>
					<li><span style="color: yellow;"><i class="fa fa-phone"></i>&nbsp; Phone Numbers :</span>
					<?php
						while ($rowofficephone = mysql_fetch_assoc($sqlofficephone)):
						echo $rowofficephone['officephoneprefix']."-".$rowofficephone['officephoneno'] ?>
					<?php
						endwhile;
					?>
					</li>
			</ul>
		</div>
		<?php
			endwhile;
		?>
	</div>


	<!-- jQuery -->
	<script src="javascripts/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="javascripts/bootstrap.min.js"></script>
	<!-- SweetAlert -->
	<script src="javascripts/sweetalert-dev.js"></script>

	<script>
		$("h3").click(function() {
			var parent = $(this).parent();
		    $('h3').nextUntil('h3').hide();
			$("ul", parent).slideToggle("fast");
		});
	</script>
	<?php
	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$suggestion = $_POST['suggestion'];

		$insertsql = mysql_query("insert into mails(name, email, feedback, sendtime) values ('$name', '$email', '$suggestion', now())") or die(mysql_error());

		echo "<script>swal({
		title: 'Success!',
		text: 'Your Mail has been sent!',
		type: 'success',
		timer: 1000,
		showConfirmButton: false
		}, function(){
		window.location.href = 'index.php';
		});</script>";
	}
	?>
	</body>
</html>