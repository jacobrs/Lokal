<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
  global $pathToSite;
  $pathToSite = $pathToRoot;
  $loggedUser = unserialize($_SESSION['user']);
  $restaurant = unserialize($_SESSION['Restaurant']);
?>
    <meta charset="utf-8">
    <title><?php echo $title?></title>
	<script src="<?php echo $pathToRoot ?>js/vendor/jquery.js" type="text/javascript" language="javascript"></script>
	<script src="<?php echo $pathToRoot ?>js/foundation.min.js" type="text/javascript" language="javascript"></script>
    <link rel="shortcut icon" href="<?php echo $pathToRoot;?>img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="<?php echo $pathToRoot ?>css/normalize.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $pathToRoot ?>css/foundation.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $pathToRoot ?>css/main.css">
    <script src="<?php echo $pathToRoot ?>js/modernizr.js" type="text/javascript" language="javascript"></script>
    <script src="<?php echo $pathToRoot ?>js/jsLibrary.js" type="text/javascript" language="javascript"></script>
  </head>
<body>
<nav class="top-bar" data-topbar data-options="is_hover: false">
  <ul class="title-area">
    <!-- Title Area -->
    <li class="name">
      <h1><a href="#">Welcome, <?php echo $loggedUser->getName(); ?></a></h1>
    </li>
    <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
  </ul>
  <section class="top-bar-section">
    <!-- Right Nav Section -->
    <ul class="right">
      <li class="divider hide-for-small"></li>
      <li class="has-dropdown"><a href="#">Manage</a>
        <ul class="dropdown"><li class="title back js-generated"></li>
          <li><label>Restaurants</label></li>
          <li class="has-dropdown"><a href="#">Restaurants</a>
            <ul class="dropdown"><li class="title back js-generated"></li>
              <?php
                genRestList($_SESSION["LinkedRestaurants"]);
              ?>
            </ul>
          </li>
          <li class="divider"></li>
          <li><label>Settings</label></li>
          <li><a href="<?php echo $pathToRoot.'settings.php';?>">Manage</a></li>
          <?php if(is_admin()){?>
          <li><a href="<?php echo $pathToRoot.'srv/admin/mkrest.php'; ?>">Add Restaurant</a></li>
          <?php } ?>
          <li><a href="<?php echo $pathToRoot.'srv/logout.php';?>">Logout</a></li>
        </ul>
      </li>
    </ul>
    <ul class="right">
      <li class="divider hide-for-small"></li>
      <li class="active"><a href="<?php echo $pathToRoot."emailInput.php"; ?>">Insert Customer</a></li>
    </ul>
    <ul class="right">
      <li class="divider hide-for-small"></li>
      <li class="active"><a href="<?php echo $pathToRoot."databaseInterface.php"; ?>">Search Code</a></li>
    </ul>
  </section>
</nav>
