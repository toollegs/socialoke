<?php
	include '/var/www/html/beta/core/globals.php';
	$uri=startPage('expired');
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://www.gorhamproductions.com/karaoke/themes/GorhamPro.min.css"><link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css"><script src="http://code.jquery.com/jquery-1.9.1.min.js"></script><script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script><!--<link rel="stylesheet" type="text/css" href="css/jquery.mobile.alphascroll.css" /><script type="text/javascript" src="js/jquery.mobile.alphascroll.js"></script><script>$( document ).ready( function() { $( '#mylistviews' ).listview( 'refresh' ).alphascroll(); $( '#mylistviewa' ).listview( 'refresh' ).alphascroll(); })</script>--></head>
<body>
<div data-role="page" id="home" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
      <!--<img src="Gorham-Productions-logo-small.jpg"/>-->
	</div>
	<div data-role="content" data-theme="f">
		<h3><center>YOU HAVE REACHED THIS PAGE IN ERROR!</center></h3>
		<a href="/beta/core/login.php?ph=<?php echo urlencode(session_get('ph')); ?>" data-role="button">Please return to Wifi Karaoke by clicking here</a>
	</div>
	<div data-role="footer" data-theme="f">
                <div style="text-align:center"> <a href="https://www.facebook.com/pages/Gorham-DJ-Services/107258289303126" rel="external"><img src="/beta/core/assets/socialoke.jpg"></a><br />Like Us</div>
                </div>
	</div>
</div>

</body>
</html>
