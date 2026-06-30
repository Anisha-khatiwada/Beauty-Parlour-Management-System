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
<title>BPMS | Between Dates Reports</title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/modernizr.custom.js"></script>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
<script> new WOW().init(); </script>
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
</head> 
<body class="cbp-spmenu-push">
    <div class="main-content">
        <?php include_once('includes/sidebar.php');?>
        <?php include_once('includes/header.php');?>
        
        <div id="page-wrapper">
            <div class="main-page">
                <div class="forms">
                    <h3 class="title1">Sales & Invoice Reports</h3>
                    <div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
                        <div class="form-title">
                            <h4 style="color: #4f52ba;">Select Date Range for Report:</h4>
                        </div>
                        <div class="form-body">
                            <form method="post" name="bwdatesreport" action="bwdates-reports-details.php">
                                
                                <div class="form-group"> 
                                    <label for="fromdate">From Date</label> 
                                    <input type="date" class="form-control" name="fromdate" id="fromdate" required='true'> 
                                </div> 
                                
                                <div class="form-group"> 
                                    <label for="todate">To Date</label>
                                    <input type="date" class="form-control" name="todate" id="todate" required='true'> 
                                </div>
                                
                                <p style="margin-bottom: 20px; color: #888; font-size: 0.9em;">
                                    * Select a previous date in "From Date" to see historical sales data.
                                </p>

                                <button type="submit" name="submit" class="btn btn-primary" style="background-color: #4f52ba; border: none; padding: 10px 30px;">Generate Report</button> 
                            </form> 
                        </div>
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