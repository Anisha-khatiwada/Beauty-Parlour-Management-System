<?php
// 1. Path to your database connection (Assuming success.php is in /payments/ folder)
include('../includes/dbconnection.php');

// 2. Get the data from eSewa (eSewa v2 sends 'data' in the URL)
$data = $_GET['data'] ?? '';

if (!$data) {
    die("Invalid Request: No response data received.");
}

// 3. Decode the Base64 response
$decoded_json = base64_decode($data);
$response = json_decode($decoded_json, true); // Fixed function name here

// 4. Extract details
$status           = $response['status'] ?? '';
$transaction_uuid = $response['transaction_uuid'] ?? '';
$refId            = $response['transaction_code'] ?? '';

if ($status === 'COMPLETE') {
    // Extract Appointment Number (From "APT-12345-timestamp")
    $parts = explode('-', $transaction_uuid);
    $AptNumber = $parts[1] ?? 0;

    // 5. Update Database Status
    // We set status to 'Selected' (or 'Confirmed') and add a Remark
    $sql = "UPDATE tblbook SET Status='Selected', Remark='Paid via eSewa Ref: $refId' WHERE AptNumber='$AptNumber'";
    mysqli_query($con, $sql);

    // 6. Show the Success UI
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Payment Successful</title>
        <link rel="stylesheet" href="../css/style.css"> <style>
            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
            .card { border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); display: inline-block; padding: 40px; }
            .btn { background: #41a124; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
        </style>
    </head>
    <body>
        <div class="card">
            <h1 style="color: #41a124;">✔ Payment Successful!</h1>
            <p>Thank you. Your payment for Appointment <b>#<?php echo $AptNumber; ?></b> was received.</p>
            <p>eSewa Ref ID: <?php echo $refId; ?></p>
            <br><br>
            <a href="../booking-history.php" class="btn">Go to Booking History</a>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "<h2>Payment failed or is pending. Status: $status</h2>";
    echo "<a href='../booking-history.php'>Back to History</a>";
}
?>