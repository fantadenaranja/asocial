<?php
	session_start();
	require_once("asocial.conf"); # Reading config file
	date_default_timezone_set('UTC+1'); # Set default time zone. Ex: UTC for UK, UTC+1 for Spain
	
	if (isset($_POST["a"])) { # Determine if a variable is set and is not NULL
		if (empty($_POST["a"])) { # Determine if is either 0, empty, or not set at all
		}else{
						
			$pattern = '|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i'; # pattern url
			$url_status = preg_match($pattern, $_POST["a"]); # checking url structure
			if ($url_status == 1) {

				$remote_asocial_conf_file= "$_POST[a]/asocial.conf";
				$handle = @fopen($remote_asocial_conf_file, "r");
				if ($handle === false) {
					echo "<p class=\"text-error\" align=\"center\">$_POST[a] is not a asocial node url</p>";
				}else{
					$_POST["a"];
					$writea = fopen($followers,"a"); # opening followers file with a mode 
					$_POST["a"]= eregi_replace("[\n|\r|\n\r]", ' ', $_POST["a"]); # removing shit
					$_POST["a"] = preg_replace('/\s+/', ' ', $_POST["a"]); # removing shit
					$_POST["a"] = htmlspecialchars($_POST["a"]); # removing shit
					$remote_url = $_POST["a"];

					
					$opts = array(
						'http'=>array(
							'method'=>"GET",
							'header'=>"Accept-language: es\r\n" .
							"User-Agent: Mozilla/5.0 (X11; U; Linux x86_64; es-ES; rv:1.9.2.23) Gecko/20110921 asocial/0.1 $url $nick/0.1"
						)
					);
					$context = stream_context_create($opts);
					$asocial_conf_file = file_get_contents("$remote_url/asocial.conf" , false, $context); # Open the file using the HTTP headers set above
					
					$title2 = strstr($asocial_conf_file, 'title="'); # getting title from remote asocial.conf file
					$title2 = strtok($title2,";"); # getting title from remote asocial.conf file
					$title2 = split('"', $title2); # getting title from remote asocial.conf file
					$email2 = strstr($asocial_conf_file, 'email="'); # getting email from remote asocial.conf file
					$email2 = strtok($email2,";"); # getting email from remote asocial.conf file
					$email2 = split('"', $email2); # getting email from remote asocial.conf file
					$nick2 = strstr($asocial_conf_file, 'nick="'); # getting nick from remote asocial.conf file
					$nick2 = strtok($nick2,";"); # getting nick from remote asocial.conf file
					$nick2 = split('"', $nick2); # getting nick from remote asocial.conf file
					$feed2="$_POST[a]/data/followme.xml"; # rss2.0 feed url

					$lines=file('./data/followers.txt');
					$nlines=count($lines);
					$i=$nlines;
					$counter=0;

					while($i!=0){
						$row = $lines[$i];
						$text = explode(";",$row);
						if ($text[1] == $title2[1] && $text[2] == $email2[1] && $text[3] == $nick2[1]) {
							$counter++;
						}
						$i--;
					}
					
					if ($counter == 0) {
						fwrite($writea,"$_POST[a];$title2[1];$email2[1];$nick2[1];$feed2\n"); # writing node
						echo "<p class=\"text-success\" align=\"center\">Asocial node $title2[1] of $nick2[1] ($email2[1]) successfully added like follower</p>";
						fclose($writea); # clossing file
					}else{
						echo "<p class=\"text-error\" align=\"center\">Currently this node is a follower</p>";
					}
				}
				fclose($handle);	
			}else{
						echo "<p class=\"text-error\" align=\"center\"> Sorry mate,  is not a right url</p>";
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
              <li><a href="timeline.php"><img src="ico/16px/16_comments.png"></a></li>
              <li><a href="friends.php"><img src="ico/16px/16_users.png"></a></li>
              <li><?php	if (!isset($_SESSION["id"])){ echo "<a href=\"login.php\"><img src=\"ico/16px/16_key.png\"></a></li>"; }else{	echo "<a href=\"index.php?out\"><img src=\"ico/16px/16_logout.png\"></a></li>"; } ?>
              <li class="active"><a href="addnode.php"><img src="ico/16px/16_server.png"></a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
		
		<div class="input-append">
			<form action="addnode.php" method="post" class="form-inline">
			<input name="a" type="text" placeholder="Add here you asocial node url" class="input-block-level" id="appendedInputButton">
			<button class="btn" type="submit">Follow me</button>
			</form>	
		</div>

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
