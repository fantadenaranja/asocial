<?php
		session_start();
		if (isset($_SESSION["contador"])) {
			
		}else{
			$lns=file('./data/posts.txt');
			$nmrlineas=count($lns);
			$nmrlineas=$nmrlineas-5;
			$_SESSION["contador"] = $nmrlineas;
		}
		
		$lineas=file('./data/posts.txt');
		$numerolineas=$_SESSION["contador"];
		$postpag=$numerolineas-5; # post per page
		
		while($numerolineas>$postpag){
			$row = $lineas[$numerolineas];
			$texto = explode("|",$row);
			if (empty($texto[0])) { 
			}else{
				echo "<li><table align=\"left\" width=\"100%\"><tr><td align=\"left\"><img src=\"avatar.jpg\" class=\"img-rounded\"></td><td align=\"left\" width=\"100%\"><blockquote align=\"left\">$numerolineas - $texto[2]<small><a href=\"$url\">$texto[0]</a> <a href=\"index.php?pid=$texto[4]\">$texto[1]</a> <a href=\"#$texto[3]\" title=\"MD5 checksum: $texto[3]\"><b> #</b></a></small></blockquote><a id=\"p$numerolineas\"></td></tr></table></li>";
			}
			$numerolineas--;
		}

		$_SESSION["contador"]=$_SESSION["contador"]-5;
		$_SESSION["pag"]=$_SESSION["contador"]+1;
		echo "<a href=\"#p$_SESSION[pag]\"><img border=\"0\" style=\"position:fixed; bottom:0; right:0;\" src=\"avatar.jpg\" title=\"more\"></a>";

?>
