<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>
<link rel="stylesheet" href="assets/css/user-dropdown.css">
<style>body{background:#ffe6f0!important;min-height:100vh}</style>
<section class=" w3l-header-4 header-sticky">
    <header class="absolute-top">
        <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <h1><a class="navbar-brand" href="index.php"> <!--<span class="fa fa-line-chart" aria-hidden="true"></span> -->
            BPMS
            </a></h1>
            <button class="navbar-toggler bg-gradient collapsed" type="button" data-toggle="collapse"
                data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="fa icon-expand fa-bars"></span>
        <span class="fa icon-close fa-times"></span>
            </button>
      
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Services</a>
                    </li> 

                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                     
                     <?php if (strlen($_SESSION['bpmsuid']==0)) {?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/index.php">Admin</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="signup.php">Signup</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li><?php }?>
                    <?php if (strlen($_SESSION['bpmsuid']>0)) {
                        $userid=$_SESSION['bpmsuid'];
                        $ret=mysqli_query($con,"select FirstName from tbluser where ID='$userid'");
                        $row=mysqli_fetch_array($ret);
                        $name=$row['FirstName'];
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="book-appointment.php">Book Appointment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="booking-history.php">Booking History</a>
                    </li>
                    <li class="nav-item dropdown ml-3">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fa fa-user"></span> <?php echo $name; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="profile.php"><span class="fa fa-user"></span> Profile</a>
                            <a class="dropdown-item" href="change-password.php"><span class="fa fa-cog"></span> Setting</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php"><span class="fa fa-sign-out"></span> Logout</a>
                        </div>
                    </li>
                  <?php }?>
                </ul>
                
            </div>
        </div>

        </nav>
    </div>
      </header>
</section>