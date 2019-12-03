<?php
include_once '../includes/config.php';
if (!isset($_SESSION['managerID']) && !isset($_COOKIE['managerID'])) {
    header('Location: SigninPage');
    exit();
} else {
    $managerID = $_SESSION['managerID'] ? $_SESSION['managerID'] : $_COOKIE['managerID'];
    $lasturl = 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $lastseen = time();
    $u2 = mysqli_query($con, "UPDATE $user_table SET lastseen='$lastseen',lasturl='$lasturl' WHERE managerID='$managerID'");
    $u1 = mysqli_query($con, "SELECT * FROM $user_table WHERE managerID='$managerID'");
    $manager = mysqli_fetch_assoc($u1);
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

    <title><?php echo $page_name.' | Manager Panel | '.$option['website_name']; ?></title>

    <!-- vendor css -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<!-- jQuery ScrollTo Plugin -->
<script src="//balupton.github.io/jquery-scrollto/lib/jquery-scrollto.js"></script>

<!-- History.js -->
<script src="//browserstate.github.io/history.js/scripts/bundled/html4+html5/jquery.history.js"></script>

<!-- Ajaxify -->
<script src="//rawgithub.com/browserstate/ajaxify/master/ajaxify-html5.js"></script>
	
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
        </a>
		<a  class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
            <span class="menu-item-label">Listings</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="NewListing" class="nav-link">New Listing</a></li>
          <li class="nav-item"><a href="MyListing" class="nav-link">All Listings</a></li>
        </ul>
        <a  class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
            <span class="menu-item-label">Projects</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="NewProject" class="nav-link">New Project</a></li>
          <li class="nav-item"><a href="AllProjects" class="nav-link">All Projects</a></li>
        </ul>
        
		
        <a  class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
            <span class="menu-item-label">Milestones/Phase</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="NewMilestone" class="nav-link">New Milestone</a></li>
          <li class="nav-item"><a href="AllMilestones" class="nav-link">All Milestones</a></li>
        </ul>
		<a class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
            <span class="menu-item-label">Tasks</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link  -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="NewTask" class="nav-link">New Task</a></li>
          <li class="nav-item"><a href="AllTasks" class="nav-link">All Tasks</a></li>
        </ul>
        <a class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-20"></i>
            <span class="menu-item-label">Contractors</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">	
          <li class="nav-item"><a href="AssignContractor" class="nav-link">Assign Contractor</a></li>
          <li class="nav-item"><a href="AllContractors" class="nav-link">All Contractors</a></li>
        </ul>
        <a class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-navigate-outline tx-24"></i>
            <span class="menu-item-label">Activity Log</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="AccountActivity" class="nav-link">Account Activities</a></li>
          <li class="nav-item"><a href="ProjectActivity" class="nav-link">Project Activities</a></li>
        </ul>
        <a class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-email-outline tx-24"></i>
            <span class="menu-item-label">Chat</span>
			<i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a>
		<ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="NewChat" class="nav-link">New Chat</a></li>
          <li class="nav-item"><a href="AllChats" class="nav-link">All Chats</a></li>
        </ul>
        <a class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-paper-outline tx-22"></i>
            <span class="menu-item-label">OtherPages</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="../index" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="SigninPage" class="nav-link">SignOut</a></li>
        </ul>
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
            <a class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name"><?php echo $manager['fullname']; ?></span>
              <img src="<?php echo $manager['photo']; ?>" class="wd-32 rounded-circle">
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
