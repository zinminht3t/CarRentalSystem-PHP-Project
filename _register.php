<?php


$customername = $_SESSION['customername'];
$customeremail = $_SESSION['customeremail'];
$customerusername = $_SESSION['customerusername'];
$customerpassword = $_SESSION['customerpassword'];
$confirmpassword = $_SESSION['confirmpassword'];
$customergender = $_SESSION['customergender'];
$customerdob = $_SESSION['customerdob'];

$customerpassword = md5($customerpassword);

$getlatestid = mysql_query("SELECT customerid FROM customers WHERE SUBSTRING(customerid,4) = (SELECT MAX(CAST(SUBSTRING(customerid,4) AS SIGNED)) FROM customers)"); 
$queryrow = mysql_num_rows($getlatestid);

if ($queryrow < 1){
	$customerid = 'cus1';
}

else{
	  while ($row = mysql_fetch_assoc($getlatestid)):
	    $lastid =  $row['customerid'];
		$lastid = preg_replace("/[^0-9]/","",$lastid);
	  endwhile;
	  $lastid = $lastid + 1;
	  $customerid = 'cus'.$lastid;
}

$registersql = mysql_query("insert into customers(customerid, customername, customerusername, customeremail, customerpassword, customergender, customerdob, signuptime) values('$customerid','$customername', '$customerusername', '$customeremail', '$customerpassword', '$customergender', '$customerdob', NOW())") or die(mysql_error());
if (isset($_POST['paypal'])) {
	$paypalemail = $_POST['paypalemail'];
	$paypalpassword = $_POST['paypalpassword'];
	$paypalpassword = md5($paypalpassword);
	$registerpaypalsql = mysql_query("insert into paypalserver(paypalemail, paypalpassword, customerid, balance) values('$paypalemail', '$paypalpassword', '$customerid', 10000)") or die(mysql_error());
	}

$_SESSION['authentication'] = true;
$_SESSION['customerusername'] = $customerusername;
$_SESSION['customerid'] = $customerid;
echo "<script>swal({
title: 'Success!',
text: 'Your account has been created!',
type: 'success',
timer: 1000,
showConfirmButton: false
}, function(){
window.location.href = 'profile.php';
});</script>";

?>