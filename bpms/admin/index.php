<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

$msg = "";

if (isset($_POST['login'])) {

    $adminuser = trim($_POST['username']);
    $password  = md5(trim($_POST['password']));

    $query = mysqli_query(
        $con,
        "SELECT ID FROM tbladmin 
         WHERE UserName='$adminuser' 
         AND Password='$password'"
    );

    if ($row = mysqli_fetch_array($query)) {
        $_SESSION['bpmsaid'] = $row['ID'];
        header("Location: dashboard.php");
        exit();
    } else {
        $msg = "Invalid Username or Password!";
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>BPMS | Login Page</title>

<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/animate.css" rel="stylesheet">

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.js"></script>
</head>

<body class="cbp-spmenu-push">
<div class="main-content">
  <div style="background-color:#F1F1F1; height:800px;">
    <div class="main-page login-page">
      <h3 class="title1">SignIn Page</h3>

      <div class="widget-shadow">
        <div class="login-top">
          <h4>Welcome back to BPMS AdminPanel!</h4>
        </div>

        <div class="login-body">
          <form method="post">
            <?php if ($msg != "") { ?>
              <p style="font-size:16px;color:red;text-align:center;">
                <?php echo $msg; ?>
              </p>
            <?php } ?>

            <input type="text" name="username" class="user"
                   placeholder="Username" required>

            <input type="password" name="password" class="lock"
                   placeholder="Password" required>

            <input type="submit" name="login" value="Sign In">

            <div class="forgot-grid">
              <div class="forgot">
                <a href="../index.php">Back to Home</a>
              </div>
              <div class="clearfix"></div>
            </div>

            <div class="forgot-grid">
              <div class="forgot">
                <a href="forgot-password.php">Forgot password?</a>
              </div>
              <div class="clearfix"></div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
