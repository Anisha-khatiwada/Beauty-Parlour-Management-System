<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

$userid = $_SESSION['bpmsuid'];

if (strlen($_SESSION['bpmsuid']==0)) {
    header('location:logout.php');
} else {
?>
<!doctype html>
<html lang="en">
<head>
    <title>Beauty Parlour Management System | Booking History</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700&display=swap" rel="stylesheet">
</head>

<body id="home">

<?php include_once('includes/header.php');?>

<section class="w3l-inner-banner-main">
    <div class="about-inner contact">
        <div class="container"> 
            <div class="main-titles-head text-center">
                <h3 class="header-name">Booking History</h3>
            </div>
        </div>
    </div>
</section>

<section class="w3l-contact-info-main">
    <div class="container">
        <h4 style="text-align:center;color:blue;margin-bottom:20px;">Appointment History</h4>

        <table border="2" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Appointment Number</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php
            // We select 'Remark' because that's where success.php saves the payment info
            $query = mysqli_query($con,"SELECT ID as bid, AptNumber, AptDate, AptTime, Services, Status, Remark 
                                        FROM tblbook 
                                        WHERE UserID='$userid' ORDER BY ID DESC");

            $cnt=1;
            if(mysqli_num_rows($query) > 0){
                while($row=mysqli_fetch_array($query)){
                    
                    // Logic to determine if paid based on the Remark column
                    $isPaid = (strpos($row['Remark'], 'Paid') !== false);
            ?>

                <tr>
                    <td><?php echo $cnt;?></td>
                    <td><?php echo $row['AptNumber'];?></td>
                    <td><?php echo $row['AptDate'];?></td>
                    <td><?php echo $row['AptTime'];?></td>

                    <td>
                        <?php 
                        if($row['Status'] == ""){
                            echo "Waiting for confirmation";
                        } else {
                            echo $row['Status'];
                        }
                        
                        echo "<br>"; 

                        // Display Payment Status
                        if($isPaid){
                            echo "<span style='color:green; font-weight:bold;'>Paid</span>";
                        } else {
                            echo "<span style='color:red; font-weight:bold;'>Unpaid</span>";
                        }
                        ?>
                    </td>

                    <td>
                        <a href="appointment-detail.php?aptnumber=<?php echo $row['AptNumber'];?>" class="btn btn-primary btn-sm">View</a>

                        <?php 
                        if($isPaid){
                            // If paid, show a disabled button or a checkmark
                            echo "<button class='btn btn-secondary btn-sm' style='margin-left:5px;' disabled>✔ Paid</button>";
                        } else {
                            // Only show "Pay Now" if it's unpaid
                            echo "<a href='payments/pay.php?aptno=".$row['AptNumber']."' class='btn btn-success btn-sm' style='margin-left:5px;'>Pay Now</a>";
                        }
                        ?>
                    </td>
                </tr>

            <?php 
                $cnt++;
                } 
            } else { 
            ?>
                <tr>
                    <td colspan="6" style="color:red;text-align:center;">No Record Found</td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
</section>

<?php include_once('includes/footer.php');?>

</body>
</html>
<?php } ?>