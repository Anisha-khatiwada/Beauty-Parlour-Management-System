<?php
// 1. Path to your database connection
include('../includes/dbconnection.php');

// 2. Get the data from eSewa
$data = $_GET['data'] ?? '';

if (!$data) {
    die("Invalid Request: No response data received.");
}

// 3. Decode the Base64 response from eSewa
$decoded_json = base64_decode($data);
$response = json_decode($decoded_json, true);

// 4. Extract details
$status           = $response['status'] ?? '';
$transaction_uuid = $response['transaction_uuid'] ?? '';
$refId            = $response['transaction_code'] ?? '';

if ($status === 'COMPLETE') {
    // Extract Appointment Number from "APT-12345-timestamp"
    $parts = explode('-', $transaction_uuid);
    $AptNumber = $parts[1] ?? 0;

    // 5. THE FIX: Update the Remark column
    // We update Status to 'Selected' and Remark to 'Paid via eSewa Ref: ...'
    // This Remark is what booking-history.php looks for!
    $sql = "UPDATE tblbook SET 
            Status='Selected', 
            Remark='Paid via eSewa Ref: $refId' 
            WHERE AptNumber='$AptNumber'";
            
    $result = mysqli_query($con, $sql);

    // DEBUG: If the update fails, this will tell us why
    if (!$result || mysqli_affected_rows($con) == 0) {
        // Fallback: Try updating by the ID if AptNumber failed
        mysqli_query($con, "UPDATE tblbook SET Status='Selected', Remark='Paid via eSewa Ref: $refId' WHERE ID='$AptNumber'");
    }

    // 6. Show Success Message
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Payment Successful</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
            .card { border: 1px solid #ddd; display: inline-block; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
            .btn { background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px;}
        </style>
    </head>
    <body>
        <div class="card">
            <h1 style="color: #28a745;">✔ Payment Successful!</h1>
            <p>Appointment <b>#<?php echo $AptNumber; ?></b> has been marked as Paid.</p>
            <p>eSewa Reference: <?php echo $refId; ?></p>
            <a href="../booking-history.php" class="btn">Back to Booking History</a>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "Payment failed. Status: " . htmlspecialchars($status);
}
?>