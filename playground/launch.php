<?php

$f = file_get_contents("/venue/live");

$json = json_decode($f,true);
$ph = $_GET['ph'];
?>
<html><head><title>SOCIALOKE LAUNCHER</title>
<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no">
<?php echo file_get_contents('/beta/core/assets/jquery-include.js'); ?>
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
