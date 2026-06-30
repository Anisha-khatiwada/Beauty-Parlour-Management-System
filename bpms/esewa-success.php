<?php
include('includes/dbconnection.php');

$booking_id = $_GET['oid'];
$refId = $_GET['refId'];

mysqli_query($con,
    "UPDATE tblbookings 
     SET payment_status='Paid', payment_ref_id='$refId' 
     WHERE ID='$booking_id'"
);
?>

<h2>Payment Successful ✅</h2>
<a href="my-bookings.php">View My Bookings</a>
