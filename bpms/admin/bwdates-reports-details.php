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
<title>BPMS || B/W date Reports</title>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/modernizr.custom.js"></script>
</head> 
<body class="cbp-spmenu-push">
    <div class="main-content">
        <?php include_once('includes/sidebar.php');?>
        <?php include_once('includes/header.php');?>
        
        <div id="page-wrapper">
            <div class="main-page">
                <div class="tables">
                    <h3 class="title1">Between dates reports</h3>
                    <div class="table-responsive bs-example widget-shadow">
                        <?php
                        $fdate=$_POST['fromdate'];
                        $tdate=$_POST['todate'];
                        ?>
                        <h4 style="color:purple;">Sales Report: <?php echo $fdate?> to <?php echo $tdate?></h4>

                        <table class="table table-bordered"> 
                            <thead> 
                                <tr> 
                                    <th>#</th> 
                                    <th>Invoice Id</th> 
                                    <th>Customer Name</th> 
                                    <th>Invoice Date</th> 
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </tr> 
                            </thead> 
                            <tbody>
<?php
// Query to get invoices between dates
$ret=mysqli_query($con,"SELECT DISTINCT tbluser.FirstName, tbluser.LastName, tblinvoice.BillingId, tblinvoice.PostingDate 
                        FROM tbluser 
                        JOIN tblinvoice ON tbluser.ID=tblinvoice.Userid 
                        WHERE DATE(tblinvoice.PostingDate) BETWEEN '$fdate' AND '$tdate'");

$cnt=1;
$grandtotal=0;
while ($row=mysqli_fetch_array($ret)) {
    
    // Calculate total for this specific invoice
    $billingid = $row['BillingId'];
    $sub_ret = mysqli_query($con, "SELECT SUM(tblservices.Cost) as totalprice 
                                   FROM tblinvoice 
                                   JOIN tblservices ON tblservices.ID=tblinvoice.ServiceId 
                                   WHERE tblinvoice.BillingId='$billingid'");
    $res = mysqli_fetch_array($sub_ret);
    $invoice_total = $res['totalprice'];
    $grandtotal += $invoice_total;
?>
                                <tr> 
                                    <th scope="row"><?php echo $cnt;?></th> 
                                    <td><?php echo $row['BillingId'];?></td>
                                    <td><?php echo $row['FirstName'];?> <?php echo $row['LastName'];?></td>
                                    <td><?php echo $row['PostingDate'];?></td> 
                                    <td style="font-weight:bold; color:green;">रू <?php echo number_format($invoice_total, 2);?></td>
                                    <td><a href="view-invoice.php?invoiceid=<?php echo $row['BillingId'];?>" class="btn btn-primary btn-sm">View</a></td> 
                                </tr> 
<?php 
$cnt++;
}?>
                                <tr style="background:#f9f9f9;">
                                    <td colspan="4" align="right"><strong>Grand Total Revenue:</strong></td>
                                    <td colspan="2"><strong style="color:blue; font-size:16px;">रू <?php echo number_format($grandtotal, 2); ?></strong></td>
                                </tr>
                            </tbody> 
                        </table> 
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('includes/footer.php');?>
    </div>
    <script src="js/classie.js"></script>
    <script src="js/bootstrap.js"> </script>
</body>
</html>
<?php } ?>