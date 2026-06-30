<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsuid']==0)) {
  header('location:logout.php');
  } else{

if(isset($_POST['submit']))
  {

    $uid=$_SESSION['bpmsuid'];
    $adate=$_POST['adate'];
    $atime=$_POST['atime'];
    $msg=$_POST['message'];
    $services=$_POST['services'];
    $aptnumber = mt_rand(100000000, 999999999);
  
    $query=mysqli_query($con,"insert into tblbook(UserID,AptNumber,AptDate,AptTime,Message,Services) value('$uid','$aptnumber','$adate','$atime','$msg','$services')");

    if ($query) {
        $_SESSION['aptno']=$aptnumber;
        echo "<script>window.location.href='payments/pay.php?aptno=$aptnumber'</script>";  
    }
  else
    {
      echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }

  
}
?>
<!doctype html>
<html lang="en">
  <head>
 

    <title>Beauty Parlour Management System | Appointment Page</title>

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <style>
    body{background:#ffe6f0!important}
    .map-content-9 form{background:#fff;padding:30px;border-radius:10px;box-shadow:0 5px 20px rgba(0,0,0,0.1)}
    .map-content-9 .form-group{margin-bottom:25px}
    .map-content-9 label{font-weight:600;color:#333;margin-bottom:8px;display:block;font-size:14px}
    .map-content-9 .form-control{height:50px;border:2px solid #e0e0e0;border-radius:8px;padding:10px 15px;font-size:15px;transition:all 0.3s ease}
    .map-content-9 .form-control:focus{border-color:#007bff;box-shadow:0 0 0 0.2rem rgba(0,123,255,.25);outline:none}
    .map-content-9 textarea.form-control{height:auto;resize:vertical}
    .map-content-9 .btn-contact{width:100%;height:50px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border:none;border-radius:8px;color:white;font-size:16px;font-weight:600;cursor:pointer;transition:all 0.3s ease;margin-top:10px}
    .map-content-9 .btn-contact:hover{transform:translateY(-2px);box-shadow:0 5px 15px rgba(102,126,234,0.4)}
    #serviceSelect{height:150px!important}
    #selectedList{padding:10px;background:#fff3f8;border:1px solid #ffc0e0;border-radius:5px;min-height:40px}
    </style>
  </head>
  <body id="home">
<?php include_once('includes/header.php');?>

<script src="assets/js/jquery-3.3.1.min.js"></script> <!-- Common jquery plugin -->
<!--bootstrap working-->
<script src="assets/js/bootstrap.min.js"></script>
<!-- //bootstrap working-->
<!-- disable body scroll which navbar is in active -->
<script>
$(function () {
  $('.navbar-toggler').click(function () {
    $('body').toggleClass('noscroll');
  })
});
</script>
<!-- disable body scroll which navbar is in active -->

<!-- breadcrumbs -->
<section class="w3l-inner-banner-main">
    <div class="about-inner contact ">
        <div class="container">   
            <div class="main-titles-head text-center">
            <h3 class="header-name ">
                
 Book Appointment
            </h3>
            <p class="tiltle-para "></p>
        </div>
</div>
</div>
<div class="breadcrumbs-sub">
<div class="container">   
<ul class="breadcrumbs-custom-path">
    <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
    <li class="active ">
        Book Appointment</li>
</ul>
</div>
</div>
    </div>
</section>
<!-- breadcrumbs //-->
<section class="w3l-contact-info-main" id="contact">
    <div class="contact-sec	">
        <div class="container">

            <div class="d-grid contact-view">
                <div class="cont-details">
                    <?php

$ret=mysqli_query($con,"select * from tblpage where PageType='contactus' ");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
                    <div class="cont-top">
                        <div class="cont-left text-center">
                            <span class="fa fa-phone text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Call Us</h6>
                            <p class="para"><a href="tel:+44 99 555 42">+<?php  echo $row['MobileNumber'];?></a></p>
                        </div>
                    </div>
                    <div class="cont-top margin-up">
                        <div class="cont-left text-center">
                            <span class="fa fa-envelope-o text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Email Us</h6>
                            <p class="para"><a href="mailto:example@mail.com" class="mail"><?php  echo $row['Email'];?></a></p>
                        </div>
                    </div>
                    <div class="cont-top margin-up">
                        <div class="cont-left text-center">
                            <span class="fa fa-map-marker text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Address</h6>
                            <p class="para"> <?php  echo $row['PageDescription'];?></p>
                        </div>
                    </div>
                    <div class="cont-top margin-up">
                        <div class="cont-left text-center">
                            <span class="fa fa-map-marker text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Time</h6>
                            <p class="para"> <?php  echo $row['Timing'];?></p>
                        </div>
                    </div>
               <?php } ?> </div>
                <div class="map-content-9 mt-lg-0 mt-4">
                    <form method="post">
                        <div class="form-group">
                            <label>Appointment Date</label>
                            <input type="date" class="form-control" name="adate" id='adate' required="true">
                        </div>
                        <div class="form-group">
                            <label>Appointment Time</label>
                            <input type="time" class="form-control" name="atime" id='atime' required="true">
                        </div>
                        <div class="form-group">
                            <label>Choose Services</label>
                            <select class="form-control" id="serviceSelect" multiple size="5" style="height:auto;">
                                <?php
                                $preselect = isset($_GET['service']) ? intval($_GET['service']) : 0;
                                $services = mysqli_query($con, "SELECT * FROM tblservices ORDER BY ServiceName");
                                while($svc = mysqli_fetch_array($services)) {
                                    $selected = ($svc['ID'] == $preselect) ? 'selected' : '';
                                    echo '<option value="'.$svc['ID'].'" data-cost="'.$svc['Cost'].'" '.$selected.'>'.$svc['ServiceName'].' - Rs. '.$svc['Cost'].'</option>';
                                }
                                ?>
                            </select>
                            <small class="form-text text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple services</small>
                            <input type="hidden" name="services" id="selectedServices">
                        </div>
                        <div class="form-group">
                            <label>Selected Services:</label>
                            <div id="selectedList" style="padding:10px;background:#f8f9fa;border-radius:5px;min-height:40px;">None selected</div>
                            <strong>Total Cost: Rs. <span id="totalCost">0</span></strong>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" id="message" name="message" placeholder="Enter your message" rows="4" ></textarea>
                        </div>
                        <button type="submit" class="btn btn-contact" name="submit">Make an Appointment</button>
                    </form>
                </div>
    </div>
   
    </div></div>
</section>
<?php include_once('includes/footer.php');?>
<!-- move top -->
<button onclick="topFunction()" id="movetop" title="Go to top">
	<span class="fa fa-long-arrow-up"></span>
</button>
<script>
	// When the user scrolls down 20px from the top of the document, show the button
	window.onscroll = function () {
		scrollFunction()
	};

	function scrollFunction() {
		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			document.getElementById("movetop").style.display = "block";
		} else {
			document.getElementById("movetop").style.display = "none";
		}
	}

	// When the user clicks on the button, scroll to the top of the document
	function topFunction() {
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	}
$(function(){
    var dtToday = new Date();
    
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();
    
    var minDate = year + '-' + month + '-' + day;
    $('#adate').attr('min', minDate);
    
    // Block past times for today
    $('#adate').on('change', function(){
        var selectedDate = $(this).val();
        if(selectedDate === minDate) {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            if(hours < 10) hours = '0' + hours;
            if(minutes < 10) minutes = '0' + minutes;
            var minTime = hours + ':' + minutes;
            $('#atime').attr('min', minTime);
        } else {
            $('#atime').removeAttr('min');
        }
    });
    
    // Service selection handler
    $('#serviceSelect').on('change', function(){
        var selected = $(this).find('option:selected');
        var services = [];
        var total = 0;
        var html = '';
        
        selected.each(function(){
            var name = $(this).text();
            var cost = parseInt($(this).data('cost'));
            services.push($(this).val());
            total += cost;
            html += '<div>' + name + '</div>';
        });
        
        if(services.length > 0) {
            $('#selectedList').html(html);
            $('#totalCost').text(total);
            $('#selectedServices').val(services.join(','));
        } else {
            $('#selectedList').html('None selected');
            $('#totalCost').text('0');
            $('#selectedServices').val('');
        }
    });
    
    // Trigger change on page load to show preselected service
    $('#serviceSelect').trigger('change');
});</script>
<!-- /move top -->
</body>

</html><?php } ?>