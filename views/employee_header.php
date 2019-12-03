<?php
include_once '../includes/config.php';
if (!isset($_SESSION['employeeID']) && !isset($_COOKIE['employeeID'])) {
    header('Location: SigninPage');
    exit();
} else {
    $employeeID = $_SESSION['employeeID'] ? $_SESSION['employeeID'] : $_COOKIE['employeeID'];
    $lasturl = 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $lastseen = time();
    $u2 = mysqli_query($con, "UPDATE $employee_table SET lastseen='$lastseen',lasturl='$lasturl' WHERE employeeID='$employeeID'");
    $u1 = mysqli_query($con, "SELECT * FROM $employee_table WHERE employeeID='$employeeID'");
    $employee = mysqli_fetch_assoc($u1);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="<?php echo $option['twitter']; ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $option['website_name']; ?>">
    <meta name="twitter:description" content="<?php echo $option['meta_desc']; ?>">

    <!-- Facebook -->
    <meta property="og:url" content="<?php echo $website_url; ?>">
    <meta property="og:title" content="<?php echo $option['website_name']; ?>">
    <meta property="og:description" content="<?php echo $option['meta_desc']; ?>">

    <meta property="og:image" content="<?php echo $website_url; ?>/images/big_logo.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="<?php echo $option['meta_desc']; ?>">
    <meta name="author" content="<?php echo $option['website_name']; ?>">

    <title><?php echo $page_name.' | Employee Panel | '.$option['website_name']; ?></title>

    <!-- vendor css -->
  
	
  </head>

  <body>
    <!-- ########## START: LEFT PANEL ########## -->
    <div class="sl-logo"><a href="index"><i class="icon ion-android-star-outline"></i> <?php echo $option['website_name']; ?></a></div>
    <div class="sl-sideleft">

      <label class="sidebar-label">Navigation</label>
      <div class="sl-sideleft-menu">
        <a href="index" class="sl-menu-link active">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">Dashboard</span>
          </div><!-- menu-item -->
        </a><a href="AllTasks" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-home tx-22"></i>
            <span class="menu-item-label">Tasks</span>
          </div><!-- menu-item -->
        </a><a href="AllChats" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon tx-22"></i>
            <span class="menu-item-label">Chats</span>
          </div><!-- menu-item -->
        </a>
        
      </div><!-- sl-sideleft-menu -->

      <br>
    </div><!-- sl-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <div class="sl-header">
      <div class="sl-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
      </div><!-- sl-header-left -->
      <div class="sl-header-right">
        <nav class="nav">
          <div class="dropdown">
            <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name"><?php echo $employee['fullname']; ?></span>
              <img src="<?php echo $employee['photo']; ?>" class="wd-32 rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-200">
              <ul class="list-unstyled user-profile-nav">
                <li><a href="EditProfile"><i class="icon ion-ios-person-outline"></i> Edit Profile</a></li>
                <li><a href="SigninPage"><i class="icon ion-power"></i> Sign Out</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
        </nav>
      </div><!-- sl-header-right -->
    </div><!-- sl-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
  
    <!-- ########## END: RIGHT PANEL ########## --->
