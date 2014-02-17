<?php

$f = file_get_contents("http://s-oke.com/venue/live");

$json = json_decode($f,true);
$ph = $_GET['ph'];
?>
<html><head><title>SOCIALOKE LAUNCHER</title>
<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="http://www.GorhamProductions.com/karaoke/themes/GorhamPro.min.css" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#v').on('change', function() {
		window.location.replace($(this).val());
	});
});
</script>
</head>
<body>
<select id="v">
	<option value="">Select a Venue:</option>
<?php
foreach($json as $venue){
?>
	<option value="<?php echo "http://s-oke.com/gig/".$venue['name']."?ph=".$ph ?>"><?php echo strtoupper($venue['name']) ?></option>
<?php 
}
?>
</select>
</body>
</html>
