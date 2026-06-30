<?php
session_start();
include('includes/dbconnection.php');

// Turn off notice & warning display (optional in production)
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// Admin session check
$isAdmin = isset($_SESSION['bpmsaid']);
?>

<div class="sticky-header header-section">
  <div class="header-left">
    <button id="showLeftPush"><i class="fa fa-bars"></i></button>

    <div class="logo">
      <a href="dashboard.php">
        <h1>BPMS</h1>
        <span>AdminPanel</span>
      </a>
    </div>
    <div class="clearfix"></div>
  </div>

  <div class="header-right">

    <!-- Notifications -->
    <div class="profile_details_left">
      <ul class="nofitications-dropdown">
        <?php
        $num = 0;
        if ($isAdmin) {
          $ret1 = mysqli_query(
            $con,
            "SELECT tbluser.FirstName, tbluser.LastName,
                    tblbook.ID as bid, tblbook.AptNumber
             FROM tblbook
             JOIN tbluser ON tbluser.ID = tblbook.UserID
             WHERE tblbook.Status IS NULL"
          );
          $num = mysqli_num_rows($ret1);
        }
        ?>

        <li class="dropdown head-dpdn">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell"></i>
            <span class="badge blue"><?php echo $num; ?></span>
          </a>

          <ul class="dropdown-menu">
            <li>
              <div class="notification_header">
                <h3>You have <?php echo $num; ?> new notification</h3>
              </div>
            </li>

            <li>
              <div class="notification_desc">
                <?php
                if ($num > 0) {
                  while ($result = mysqli_fetch_array($ret1)) {
                ?>
                  <a class="dropdown-item"
                     href="view-appointment.php?viewid=<?php echo $result['bid']; ?>">
                    New appointment from
                    <?php echo htmlentities($result['FirstName'] . " " . $result['LastName']); ?>
                    (<?php echo htmlentities($result['AptNumber']); ?>)
                  </a>
                  <hr />
                <?php
                  }
                } else {
                ?>
                  <a class="dropdown-item" href="#">No New Appointment Received</a>
                <?php } ?>
              </div>
            </li>

            <li>
              <div class="notification_bottom">
                <a href="new-appointment.php">See all notifications</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>

    <!-- Admin Profile -->
    <div class="profile_details">
      <?php
      $name = "Admin";
      if ($isAdmin) {
        $adid = $_SESSION['bpmsaid'];
        $ret = mysqli_query($con, "SELECT AdminName FROM tbladmin WHERE ID='$adid'");
        if ($row = mysqli_fetch_array($ret)) {
          $name = $row['AdminName'];
        }
      }
      ?>

      <ul>
        <li class="dropdown profile_details_drop">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="profile_img">
              <span class="prfil-img">
                <img src="images/admin.png" width="50" height="50">
              </span>
              <div class="user-name">
                <p><?php echo htmlentities($name); ?></p>
                <span>Laxmi</span>
              </div>
              <i class="fa fa-angle-down lnr"></i>
              <i class="fa fa-angle-up lnr"></i>
              <div class="clearfix"></div>
            </div>
          </a>
          

          <ul class="dropdown-menu drp-mnu">
            <li><a href="change-password.php"><i class="fa fa-cog"></i> Settings</a></li>
            <li><a href="admin-profile.php"><i class="fa fa-user"></i> Profile</a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
