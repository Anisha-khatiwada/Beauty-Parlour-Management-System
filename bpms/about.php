<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Get logged in user ID
$userid = $_SESSION['bpmsuid'];
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Beauty Parlour Management System | About us Page</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700&display=swap" rel="stylesheet">
  </head>
  <body id="home">
<?php include_once('includes/header.php');?>

<section class="w3l-inner-banner-main">
    <div class="about-inner about ">
        <div class="container">    
            <div class="main-titles-head text-center">
                <h3 class="header-name ">About Us</h3>
            </div>
        </div>
    </div>
</section>

<section class="w3l-content-with-photo-4" id="about">
    <div class="content-with-photo4-block ">
        <div class="container">
            <div class="cwp4-two row">
                <div class="cwp4-image col-xl-6">
                    <img src="assets/images/cf4e4dff00d951b40b43e24cdfeabae41652852685.jpg" alt="product" class="img-responsive about-me">
                </div>
                <div class="cwp4-text col-xl-6 ">
                    <div class="posivtion-grid">
                    <h3 class="">Recommended For You</h3>
                    <p class="para mt-3">Services you haven't tried yet, specifically selected for you.</p>
                    
                    <?php
                    // ALGORITHM IMPLEMENTATION:
                    // R(u) = S - B(u)
                    // We select services that are NOT in the user's booking history
                    if($userid > 0) {
                        $sql = "SELECT * FROM tblservices 
                                WHERE ServiceName NOT IN (SELECT Services FROM tblbook WHERE UserID = '$userid') 
                                ORDER BY RAND() LIMIT 3";
                    } else {
                        // Fallback for guests: show random 3
                        $sql = "SELECT * FROM tblservices ORDER BY RAND() LIMIT 3";
                    }

                    $recommended = mysqli_query($con, $sql);
                    while($service = mysqli_fetch_array($recommended)) {
                    ?>
                    <div style="border:1px solid #eee; padding:15px; margin:15px 0; border-radius:8px; background:#f9f9f9; box-shadow: 2px 2px 5px rgba(0,0,0,0.05);">
                        <h5 style="color:purple;"><?php echo $service['ServiceName']; ?></h5>
                        <p class="para" style="font-size:14px;">
                            <?php echo substr($service['ServiceDescription'], 0, 80); ?>...
                        </p>
                        <p style="margin-top:10px;"><strong>Price: Rs. <?php echo $service['Cost']; ?></strong></p>
                        
                        <a href="book-appointment.php" class="btn btn-primary" style="background:purple; border:none; padding:6px 15px; font-size:13px; color:white; border-radius:4px;">Book Now</a>
                    </div>
                    <?php } ?>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="w3l-recent-work">
    <div class="jst-two-col">
        <div class="container">
            <div class="row">
                <div class="my-bio col-lg-6">
                    <div class="hair-make">
                        <?php
                        $ret=mysqli_query($con,"select * from tblpage where PageType='aboutus' ");
                        while ($row=mysqli_fetch_array($ret)) {
                        ?>
                        <h5><?php echo $row['PageTitle'];?></h5>
                        <p class="para mt-2"><?php echo $row['PageDescription'];?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-6 ">
                    <img src="assets/images/cf4e4dff00d951b40b43e24cdfeabae41652852685.jpg" alt="product" class="img-responsive about-me">
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once('includes/footer.php');?>

<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>