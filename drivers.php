<?php
	//to use session
	session_start();
	//for mysql database connection
	include('dbconfig/dbconfig.php');
	
	if (!isset($_SESSION['authentication'])) {
		echo "<script>window.location.href = 'index.php';</script>";
	}
	

	$customerid = $_SESSION['customerid'];
	$currentpage = 'drivers';


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Xero | Drivers</title>

		<!-- Bootstrap -->
		<link href="style/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="fa/css/font-awesome.min.css" rel="stylesheet">
		<!-- Sweet Alert -->
		<link rel="stylesheet" href="style/sweetalert.css">
		<link rel="stylesheet" href="style/rating.css">
		<!-- Custom Style -->
		<link href="style/customstyle.css" rel="stylesheet">
		<!-- Site Logo -->
		<link href = "images/design/logo.png" rel="icon" type="image/png">

	</head>

	<body class="other">

		<?php include '_navigationbar.php'; ?> <!-- navigation bar -->

		<div class="container adjustnavpositon">
			<div class="row">
				<div class="col-md-9">
					<h3>Drivers that are avilable at Xero Car Rental</h3>
				</div>
				<div class="col-md-3">
		        	<input type="text" class="text-input form-control" id="filter" placeholder="Search Here" value=""/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<?php
                  # Paging
                    $limit = 10;
                    $start = 0;
                    if(isset($_GET['start'])) {
                        $start = $_GET['start'];
                    }
                    
                    $next = $start + $limit; 
                    $prev = $start - $limit;

                    $total = mysql_query("SELECT * FROM drivers where driverid != 'nodriver' and Active = 1");
                    $total = mysql_num_rows($total);

					$getdriversquery = mysql_query("SELECT * FROM drivers where driverid != 'nodriver'  and active = 1 ORDER BY driverexperience DESC LIMIT $start, $limit");
					while ($rowgetdrivers = mysql_fetch_assoc($getdriversquery)):
						$driverid = $rowgetdrivers['driverid'];
					?>

					<div class="row driver">
						<div class="col-md-3">
							<img src="images/driverphoto/<?php echo $rowgetdrivers['driverphoto']; ?>" width="200px" height="200px" alt="">
						</div>

						<div class="col-md-3">

							<ul class="list-unstyled user_data">
								<li><i class="fa fa-user-circle-o user-profile-icon"></i> <?php echo $rowgetdrivers['driverusername']; ?>
								</li>

								<li>
								<i class="fa fa-envelope user-profile-icon"></i> <?php echo $rowgetdrivers['driveremail']; ?>
								</li>

								<li>
								<i class="fa fa-male user-profile-icon"></i> <?php echo $rowgetdrivers['drivergender']; ?>
								</li>

								<li>
								<i class="fa fa-drivers-license-o user-profile-icon"></i> <?php echo $rowgetdrivers['driverstatus']; ?>
								</li>

								<li>
								<i class="fa fa-globe user-profile-icon"></i> <?php echo $rowgetdrivers['driverexperience']; ?> years experience
								</li>

								<li>
								<i class="fa fa-money user-profile-icon"></i> <?php echo $rowgetdrivers['drivercost'];$getofficeid = $rowgetdrivers['officeid']; ?> per day
								</li>

								<li>
								<?php
									$getofficesql = mysql_query("select * from offices where officeid = '$getofficeid'") or die(mysql_error());
									$rowgetoffice = mysql_fetch_assoc($getofficesql);
								?>
								<i class="fa fa-home user-profile-icon"></i> From <?php echo $rowgetoffice['officename']; ?> Office
								</li>
							</ul>
						</div>

						<div class="col-md-3">
							<?php
								$countrating = mysql_query("SELECT * FROM driverratings dr, customers c WHERE dr.customerid = c.customerid AND driverid = '$driverid'") or die(mysql_error());
								$rowcountrating = mysql_num_rows($countrating);

							?>
							<h4>Ratings</h4>
							<?php
								if($rowcountrating == 0):
							?>
								<p>Not Enough Ratings to show!</p>
							<?php
								else:
								for ($i=0; $i < $rowgetdrivers['driverrating']; $i++) { 
							?>
								<img src="images/design/star.png" width="20px" alt="">
							<?php
								}
							?>
							(Based on <?php echo $rowcountrating; ?> users)
							<?php endif;?>
							<hr>
							<h4><i class="fa fa-comments"></i> Comments</h4>
							<?php
								$getcommentssql = mysql_query("SELECT * FROM driverratings dr, customers c WHERE dr.CustomerID = c.CustomerID AND driverid = '$driverid' order by dr.ratingtime DESC limit 2 ") or die(mysql_error());
								$rownogetcomments = mysql_num_rows($getcommentssql);
								if ($rownogetcomments < 1) {
							?>
							<p>There is no comment to show yet!</p>
							<?php
								} else{
							?>
							<ul class="list-unstyled comments">
							<?php
								while ($rowgetcomments = mysql_fetch_assoc($getcommentssql)):
							?>
								<li>
									<span style="color: black"><strong><i class="fa fa-user"></i> <?php echo $rowgetcomments['customerusername']; ?></strong></span> : <em><?php echo $rowgetcomments['driverreview']; ?></em> 
								</li>
							<?php endwhile; ?>
							</ul>
							<?php } ?>
						</div>

						<div class="col-md-3">
							<?php
							$driverid = $rowgetdrivers['driverid'];
							$checkuserratingsql = mysql_query("select * from driverratings where customerid = '$customerid' and driverid = '$driverid'") or die(mysql_error());
							$rowcheckuserrating = mysql_num_rows($checkuserratingsql);
							if($rowcheckuserrating > 0):
							$rowuserrating = mysql_fetch_assoc($checkuserratingsql);
							$userrating = $rowuserrating['driverrating'];
							$one = ''; $two = ''; $three = ''; $four = ''; $five = '';
							for ($i=1; $i < 6; $i++) { 
								switch ($userrating) {
									case '1':
										$one = 'checked';
										break;
									case '2':
										$two = 'checked';
										break;
									case '3':
										$three = 'checked';
										break;
									case '4':
										$four = 'checked';
										break;
									case '5':
										$five = 'checked';
										break;
									default:
										# code...
										break;
								}
							}
							?>
							<div class="driverrating form-group">
							    <input type="radio" name="rating" class="rating" <?php echo $one; ?> value="1" />
							    <input type="radio" name="rating" <?php echo $two; ?>  class="rating" value="2" />
							    <input type="radio" name="rating" <?php echo $three; ?> class="rating" value="3" />
							    <input type="radio" name="rating" <?php echo $four; ?> class="rating" value="4" />
							    <input type="radio" name="rating" <?php echo $five; ?> class="rating" value="5" />
							</div>

							<div class="form-group">
								<p><i class="fa fa-comment"></i> <?php echo $rowuserrating['driverreview']; ?></p>
							</div>

							<div class="form-group">
								<a href="_editdriverrating.php?driverid=<?php echo $driverid; ?>&&customerid=<?php echo $customerid; ?>">
									<button class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Edit Rating</button>
								</a>
							</div>


							<?php else: ?>
							<div class="ratingdriver">
								<form method="post">
									<input type="hidden" name="driverid" value="<?php echo $rowgetdrivers['driverid']; ?>">
									<div class="driverrating form-group">
									    <input type="radio" name="rating" class="rating" value="1" />
									    <input type="radio" name="rating" class="rating" value="2" />
									    <input type="radio" name="rating" class="rating" value="3" />
									    <input type="radio" name="rating" class="rating" value="4" />
									    <input type="radio" name="rating" class="rating" value="5" />
									</div>

									<div class="form-group">
									    <textarea name="comment" rows="3" class="form-control" placeholder="Your Comment" required></textarea>
									</div>

									<div class="form-group">
									    <input type="submit" name="rate" class="btn btn-primary" value="Submit">
									</div>
								</form>
							</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endwhile; ?>
				</div>
			</div>
			<div class="row">
	            <div class="paging" style="text-align: center; font-size: 30px; margin-bottom: 50px; color: white;">
	                <?php if($prev < 0): ?>
	                <?php else: ?> 
	                <a href="?start=<?php echo $prev ?>" style="text-decoration: none; color: yellow;" class="pull-left">&laquo; Previous</a>
	                <?php endif; ?>
	                
	                <?php if($next >= $total): ?>
	                <?php else: ?> 
	                <a href="?start=<?php echo $next ?>" style="text-decoration: none; color: yellow;" class="pull-right">Next &raquo;</a>
	                <?php endif; ?>
	            </div>
			</div>
		</div>

			
	</body>

	<!-- jQuery -->
	<script src="javascripts/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="javascripts/bootstrap.min.js"></script>
	<script src="javascripts/rating.js"></script>
	<!-- SweetAlert -->
	<script src="javascripts/sweetalert-dev.js"></script>
	<script>
	$('.driverrating').rating();
	$(document).ready(function(){
    $("#filter").keyup(function(){
 
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;
 
        // Loop through the comment list
        $(".driver").each(function(){
 
            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
 
            // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).show();
                count++;
            }
        });
        // Update the count
        var numberItems = count;
    });
});
	</script>
	<?php
	if (isset($_POST['rate'])) {
		$rating = $_POST['rating'];
		$comment = $_POST['comment'];

		$customerid = $_SESSION['customerid'];
		$driverid = $_POST['driverid'];

		$insertratingsql = mysql_query("INSERT INTO driverratings(driverid, customerid, driverrating, driverreview, ratingtime) VALUES('$driverid', '$customerid', '$rating', '$comment', NOW())") or die(mysql_error());

		$updateratingavg = mysql_query("UPDATE drivers SET driverrating = (SELECT AVG(driverrating) FROM driverratings WHERE driverratings.driverid = '$driverid') WHERE drivers.driverid = '$driverid'") or die(mysql_error());
  		echo "<script>swal({
		  title: 'Success!',
		  text: 'Your Comment has been saved!',
		  type: 'success',
		  timer: 1000,
		  showConfirmButton: false
		}, function(){
		      window.location.href = 'drivers.php';
		});</script>";
	}

	?>
</html>