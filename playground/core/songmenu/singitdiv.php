<div data-role="page" id="singit" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
      		<h1> <?php echo strtoupper(str_replace('&apos;',"'",$smsstring)); ?> </h1>
	</div>
	<div data-role="content"  data-theme="f">	
		<ul id="mylistview" data-role="listview" data-theme="f">
			<li data-theme="f"><a href="../ui/ui.php?t=<?php echo urlencode($smsstring); ?>" class="hover">Sing it!</a></li>
<!--
			<li data-theme="f" id="atf"><a href="#" id="<?php echo urlencode($smsstring); ?>" class="hover">Add To Favorites</a></li>
-->
			<li data-theme="f"><span>Lyrics<img src="../assets/coming-soon.jpg"/></span></li>
			<li data-theme="f"><span>YouTube<img src="../assets/coming-soon.jpg"/></span></li>
		</ul>
	</div>
	<div id="back-button" class="centerer">
		<h3><a href="/beta/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
	</div>
	<?php include_once('/var/www/html/beta/core/assets/footer.php'); ?>
</div>
