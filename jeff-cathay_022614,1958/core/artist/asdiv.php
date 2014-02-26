<div data-role="page" id="<?php echo str_replace(' ',':-',$key); ?>" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1><?php echo strtoupper(firstlast($a)); ?></h1>
	</div>
	<div id="back-button" class="centerer">
                <h3><a href="/beta/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        </div>
	<div data-role="content" data-theme="f">	
	<ul id="mylistviews" data-role="listview" data-theme="f">
<?php
		foreach($songs as $song) {
		$songArr = explode(' - ',$song);
		$justartist = trim($songArr[0]);
		$justsong = trim($songArr[1]);
		$smsstring = $justsong.' by '.$justartist; 
		$href = "/beta/core/sm/sm.php?s=".urlencode(str_replace(' - ',' by ',$smsstring));
?>
		<li data-theme="f"><a href="<?php echo $href ?>" class="hover"><?php echo $justsong; ?></a></li>
<?php
		}
?>
	</ul>
	</div>
	<div id="back-button" class="centerer">
                <h3><a href="/beta/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        </div>
	<?php include_once('/var/www/html/beta/core/assets/footer.php'); ?>
</div>
