<?php
	session_start();
	require_once("asocial.conf"); # Reading config file
	date_default_timezone_set('UTC+1'); # Set default time zone. Ex: UTC for UK, UTC+1 for Spain
	
	if (isset($_GET["out"])) {
		session_unset();
		session_destroy();
	}
	
	if (isset($_GET["ping"])) { # Ping for update timeline
		if (empty($_GET["ping"])) { # Determine if is either 0, empty, or not set at all
		}else{	
			$pattern = '|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i'; # pattern url
			$url_status = preg_match($pattern, $_GET["ping"]); # checking url structure
			if ($url_status == 1) {
			
				$lines=file('./data/followers.txt');
				$nlines=count($lines);
				$i=$nlines;
				$count=0;

				while($i!=0){
					$row = $lines[$i];
					$text = explode(";",$row);
					if ($text[0] == $_GET[ping]) { # checking if is a follower url
						$title_xml="$text[1]";
						$nick_xml="$text[3]";
						$count++;
					}
					$i--;
				}
				
				if ($count == 1) {
					
					$opts = array(
						'http'=>array(
							'method'=>"GET",
							'header'=>"Accept-language: es\r\n" .
							"User-Agent: Mozilla/5.0 (X11; U; Linux x86_64; es-ES; rv:1.9.2.23) Gecko/20110921 asocial/0.1 $url $nick/0.1"
						)
					);
					$context = stream_context_create($opts);
					$remote_url = $_GET["ping"];
					$asocial_xml_file = file_get_contents("$remote_url/data/followme.xml" , false, $context);
					$date_xml = split('>', $asocial_xml_file);
					$date_xml= "$date_xml[23]";
					$date_xml = split('<', $date_xml);
					$date_xml= "$date_xml[0]";
					
					$li=file('./data/timeline.txt');
					$nuli=count($li);
					$i=$nuli;
					$i--;
					$equo=0;
					$other=$i-10;

					while($i!=$other){
						$row = $li[$i];
						$tex = explode(";",$row);
						$i--;
						if ($tex["2"]==$date_xml) {
							$equo++;
							exit();
						}
					}
					if ($equo == 0) {
						$writet = fopen('./data/timeline.txt',"a");
						$tdate=date('l jS \of F Y h:i:s A'); # Pub date
						fwrite($writet,"$nick_xml;$tdate;$date_xml;$title_xml;$remote_url\n"); # writing timeline
						fclose($writet);
					}		
				}
			}		
		}
	} 
	
	
	if (isset($_POST["p"])) { # Determine if a variable is set and is not NULL
		if (empty($_POST["p"])) { # Determine if is either 0, empty, or not set at all
		}else{
			if (!isset($_SESSION["time"])){
				$_SESSION["time"] = time();
				$timenow=time();
				$time_last_pub=$_SESSION["time"];
				$status_time=$timenow - $time_last_pub;
			}else{
				$timenow=time();
				$time_last_pub=$_SESSION["time"];
				$status_time=$timenow - $time_last_pub;
				$_SESSION["time"]=$timenow;
			}
			
			if ($status_time > 60) {
			
				$_POST["p"];
				$writep = fopen($posts,"a");
				$_POST["p"]= eregi_replace("[\n|\r|\n\r]", ' ', $_POST["p"]); # removing shit
				$_POST["p"] = preg_replace('/\s+/', ' ', $_POST["p"]); # removing shit
				$_POST["p"] = htmlspecialchars($_POST["p"]); # removing shit
				$pdate=date('l jS \of F Y h:i:s A'); # Pub date
				fwrite($writep,"$nick;$pdate;$_POST[p]\n"); # writing post
				fclose($writep);
				if (file_exists($rss_file)) { # Determine if the file exists
					$writer = fopen($rss_file,"w"); # Opening file to write inside
					$rdate=date('l jS \of F Y h:i:s A'); # Pub rss date
					fwrite($writer, "<?xml version=\"1.0\"?>\n<rss version=\"2.0\">\n\t<channel>\n\t\t<title>$title</title>\n\t\t<link>$url</link>\n\t\t<description>$nick feed rss asocial $title network</description>\n\t\t<language>es-es</language>\n\t\t<pubDate>$rdate</pubDate>\n\t\t<lastBuildDate>$rdate</lastBuildDate>\n\t\t<webMaster>$email</webMaster>\n\t\t<item>\n\t\t\t<title>$nick $pdate</title>\n\t\t\t<link>$url</link>\n\t\t\t<description>$_POST[p]</description>\n\t\t\t<pubDate>$pdate</pubDate>\n\t\t\t<guid>item573</guid>\n\t\t</item>\n\t</channel>\n</rss>");		
					fclose($writer); 
				}
				
				$lin=file('./data/followers.txt');
				$nlin=count($lin);
				$i=$nlin;
				while($i!=0){
					$row = $lin[$i];
					$textu = explode(";",$row);
					$update_timeline = file_get_contents($textu[0]."/index.php?ping=$url"); # ping update
					$i--;
				}
			
			}else{
					echo "<p class=\"text-error\" align=\"center\">sorry dude , you need wait 60 seconds between every publication</p>";
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
              <li class="active"><a href="index.php"><img src="ico/16px/16_home.png"></a></li>
              <li><a href="timeline.php"><img src="ico/16px/16_comments.png"></a></li>
              <li><a href="friends.php"><img src="ico/16px/16_users.png"></a></li>
              <li><a href="addnode.php"><img src="ico/16px/16_server.png"></a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
		
		<?php
		if (!isset($_SESSION["id"])){
		}else{
			?>
			<div class="input-append">
				<form action="." method="post" class="form-inline">
					<input name="p" type="text" placeholder="What's Up?" class="input-block-level" id="appendedInputButton">
					<button class="btn" type="submit">Send</button>
				</form>	
			</div>
			<?php
		}
		$lineas=file('./data/posts.txt');
		$numerolineas=count($lineas);
		$i=$numerolineas;
		$i--;
		$counter=20;
		
		echo "<table align=\"left\" width=\"100%\">";
		
		while($i!=0){
			$row = $lineas[$i];
			$texto = explode(";",$row);
			if ($i == $numerolineas) {
				echo "<tr><td align=\"left\"><img src=\"avatar.jpg\" class=\"img-rounded\"></td><td align=\"left\" width=\"100%\"><blockquote align=\"left\">$texto[2]<small><a href=\"$url\">$texto[0]</a> $texto[1]</small></blockquote></td></tr>";
			}
			echo "<tr><td align=\"left\"><img src=\"avatar.jpg\" class=\"img-rounded\"></td><td align=\"left\" width=\"100%\"><blockquote align=\"left\">$texto[2]<small><a href=\"$url\">$texto[0]</a> $texto[1]</small></blockquote></td></tr>";
			$counter--;
			if ($counter == 0) {
				exit();
			}
			$i--;
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
