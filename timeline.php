<?php
	session_start();
	require_once("asocial.conf"); # Reading config file
	date_default_timezone_set('UTC+1'); # Set default time zone. Ex: UTC for UK, UTC+1 for Spain
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
          <a class="brand" href="index.php">
			<?php
			if (!isset($_SESSION["id"])){
				echo "$title";
			}else{
				echo "$nick";
			}  
			?>
		  </a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="index.php"><img src="ico/16px/16_home.png"></a></li>
              <li class="active"><a href="timeline.php"><img src="ico/16px/16_comments.png"></a></li>
              <li><a href="friends.php"><img src="ico/16px/16_users.png"></a></li>
			  <li><?php	if (!isset($_SESSION["id"])){ echo "<a href=\"login.php\"><img src=\"ico/16px/16_key.png\"></a></li>"; }else{	echo "<a href=\"index.php?out\"><img src=\"ico/16px/16_logout.png\"></a></li>"; } ?>
              <li><a href="addnode.php"><img src="ico/16px/16_server.png"></a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
		
		<?php
		$lineas=file('./data/timeline.txt');
		$numerolineas=count($lineas);
		$postpag=$numerolineas-10; # post on timeline per page
		
		echo "<table align=\"left\" width=\"100%\">";
		
		while($numerolineas>$postpag && $numerolineas!=0){
			$row = $lineas[$numerolineas];
			$texto = explode(";",$row);
			if (empty($texto[0])) { 
			}else{
				echo "<tr><td align=\"left\"><a href=\"$texto[4]\"><img src=\"$texto[4]/avatar.jpg\" class=\"img-rounded\" title=\"$texto[3]\"></a></td><td align=\"left\" width=\"100%\"><blockquote align=\"left\">$texto[2]<small><a href=\"$texto[4]\">$texto[0]</a> $texto[1]</small></blockquote></td></tr>";
			}
			$numerolineas--;
		}
		if ($numerolineas > 0) { # show link to load more if we really have more posts
			echo "<tr><td align=\"left\">&nbsp;</td><td align=\"left\" width=\"100%\"><p align=\"center\"><a href=\"#\"><img src=\"ico/16px/16_refresh.png\"> Cargar más</a></p></td></tr>";
		}else{
		}
		echo "</table>";

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
