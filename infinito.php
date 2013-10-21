<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title> test infinito</title>
    <meta name="fanta" content="">
	<link href="css/bootstrap.css" rel="stylesheet">
	
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/scroll.jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
 
			$( '#infinite_scroll' ).scrollLoad({
 
				url : 'infinito.php', //your ajax file to be loaded when scroll breaks ScrollAfterHeight
 
				getData : function() {
					//you can post some data along with ajax request
				},
 
				start : function() {
					$('<div class="loading">leyendo ...</div>').appendTo(this); // you can add your effect before loading data
				},
 
				ScrollAfterHeight : 95,			//this is the height in percentage after which ajax stars
 
				onload : function( data ) {
					$(this).append( data );
					$('.loading').remove();
				}, // this event fires on ajax success
 
				continueWhile : function( resp ) {
					if( $(this).children('li').length >= 100 ) { // stops when number of 'li' reaches 100
						return false;
					}
					return true; 
				}
			});
 
		});
 
		</script>
	
	
</head>
<body>
<ul id="infinite_scroll">
<?php
      for($i=0;$i<15;$i++)
	{
	?>
           <li>
              <a href="">This is my some title and is at number <?php echo $i ?></a><p>Lorem ipsum dolor sit                  amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
            </li>
	<?php
	}
	?>
</ul>
</body>
</head>
