<?php
	require_once("asocial.conf"); # Reading config file
	date_default_timezone_set('UTC+1'); # Set default time zone. Ex: UTC for UK, UTC+1 for Spain
	
	if (isset($_POST["key"])) { # Determine if a variable is set and is not NULL
		if (empty($_POST["key"])) { # Determine if is either 0, empty, or not set at all
		}else{			
			if ($_POST["key"] == "zapatero") {
				session_start();
				if (!isset($_SESSION["id"])){
					$_SESSION["id"] = Session_id();
				}
			}
		}
	}	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo "$title $version - $nick"; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="asocial network" content="">
    <meta name="fanta" content="">
	<link href="css/bootstrap.css" rel="stylesheet">
	<style>
		body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
		}
	</style>
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="ico/favicon.png">
</head>


<body>
	
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="index.php"><?php echo "$title"; ?></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="index.php"><img src="ico/16px/16_home.png"></a></li>
              <li><a href="timeline.php"><img src="ico/16px/16_comments.png"></a></li>
              <li><a href="friends.php"><img src="ico/16px/16_users.png"></a></li>
              <li class="active"><?php	if (!isset($_SESSION["id"])){ echo "<a href=\"login.php\"><img src=\"ico/16px/16_key.png\"></a></li>"; }else{	echo "<a href=\"index.php?out\"><img src=\"ico/16px/16_logout.png\"></a></li>"; } ?>
              <li><a href="addnode.php"><img src="ico/16px/16_server.png"></a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
		
		<?php
		if (!isset($_SESSION["id"])){
			?>			
			<div class="input-append">
				<form action="login.php" method="post" class="form-inline">
					<input name="key" type="password" placeholder="key" class="input-block-level" id="appendedInputButton">
					<button class="btn" type="submit">login</button>
				</form>	
			</div>
			<?php
		}else{
			echo "<p class=\"text-success\" align=\"center\">wellcome to home</p>";
			header('Location: index.php');
		}
		?>
	
    </div> <!-- /container -->

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>	


</body>
</html>
