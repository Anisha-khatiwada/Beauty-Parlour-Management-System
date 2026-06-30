<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
} else {
?>
<!DOCTYPE HTML>
<html>
<head>
<title>BPMS | Payments Report</title>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
</head> 
<body class="cbp-spmenu-push">
    <div class="main-content">
        <?php include_once('includes/sidebar.php');?>
        <?php include_once('includes/header.php');?>
        
        <div id="page-wrapper">
            <div class="main-page">
                <div class="tables">
                    <h3 class="title1">Payments Report</h3>
                    <div class="table-responsive bs-example widget-shadow">
                        <h4>Online eSewa Payments:</h4>
                        <table class="table table-bordered"> 
                            <thead> 
                                <tr> 
                                    <th>#</th> 
                                    <th>Apt Number</th> 
                                    <th>Customer Name</th> 
                                    <th>Services</th> 
                                    <th>Amount Paid</th> 
                                    <th>Transaction Date</th>
                                    <th>eSewa Ref ID</th> 
                                </tr> 
                            </thead> 
                            <tbody>
<?php
// Filter for records where Remark contains "Paid"
$ret=mysqli_query($con,"SELECT tbluser.FirstName, tbluser.LastName, tblbook.AptNumber, tblbook.Services, tblbook.Remark, tblbook.AptDate 
                        FROM tblbook 
                        JOIN tbluser ON tbluser.ID=tblbook.UserID 
                        WHERE tblbook.Remark LIKE '%Paid%'");
$cnt=1;
$total_revenue=0;

while ($row=mysqli_fetch_array($ret)) {
    // Logic to extract Price: We sum the cost of services listed in the 'Services' IDs
    $sids = $row['Services'];
    $price_query = mysqli_query($con, "SELECT SUM(Cost) as total FROM tblservices WHERE ID IN ($sids)");
    $price_row = mysqli_fetch_array($price_query);
    $amt = $price_row['total'];
    $total_revenue += $amt;

    // Extract Ref ID from Remark (Paid via eSewa Ref: XXXXX)
    $remark_parts = explode(': ', $row['Remark']);
    $refid = $remark_parts[1] ?? 'N/A';
?>
                                <tr> 
                                    <th scope="row"><?php echo $cnt;?></th> 
                                    <td><?php echo $row['AptNumber'];?></td> 
                                    <td><?php echo $row['FirstName'];?> <?php echo $row['LastName'];?></td> 
                                    <td><?php echo $row['Services'];?></td> 
                                    <td style="color:green; font-weight:bold;">Rs. <?php echo $amt;?></td> 
                                    <td><?php echo $row['AptDate'];?></td>
                                    <td><?php echo $refid;?></td> 
                                </tr> 
<?php 
$cnt=$cnt+1;
}?>
                                <tr>
                                    <td colspan="4" align="right"><strong>Total Collected Revenue:</strong></td>
                                    <td colspan="3"><h4 style="color:blue;">Rs. <?php echo $total_revenue; ?></h4></td>
                                </tr>
                            </tbody> 
                        </table> 
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('includes/footer.php');?>
    </div>
</body>
</html>
<?php } ?>