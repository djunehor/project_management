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

    <title><?php echo $page_name." | ".$option['website_name']; 
$_SESSION['MyCode'] = rand(0000,4444).rand(0000,9999); ?></title>

    <!-- vendor css -->
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">


    <!-- Starlight CSS -->
    <link rel="stylesheet" href="../css/starlight.css">
  </head>
  <body>

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">

      <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse"><span class="tx-info tx-normal"><?php echo $option['website_name']; ?></span></div>
        <div class="tx-center mg-b-60"><?php echo $option['website_tag']; ?></div>