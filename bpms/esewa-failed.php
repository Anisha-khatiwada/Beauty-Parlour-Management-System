<?php
include('includes/dbconnection.php');

$booking_id = $_GET['oid'];

mysqli_query($con,
    "UPDATE tblbookings 
     SET payment_status='Failed' 
     WHERE ID='$booking_id'"
);
?>

<h2>Payment Failed ❌</h2>
<a href="my-bookings.php">Go Back</a>
