<div data-role="page" id="home" dataOA-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1>SOCIALOKE</h1>
	</div>
	<div data-role="content" data-theme="f">	
		<p style="text-align:center; margin-top: 2px;"> Please select an option below to start exploring our gigantic song collection! </p>
		<div id="s">
			<form method=GET action="/beta/jeff-cathay_022614,1958/core/chooser.php?guid=<?php echo n_digit_random(4); ?>" id="mainForm" name="mainForm">
				<fieldset>
					<div data-role="fieldcontain" style="text-align:center;">
					<input type="text" name="q" id="q" value="enter something" onclick="javascript: this.value = '';"/>
					</div>
					<fieldset data-role="controlgroup" data-type="horizontal" style="text-align:center;">
						<input type="submit" name="b" id="b-1" value="SONG SEARCH"/>
						<input type="submit" name="b" id="b-2" value="ARTIST SEARCH"/>
					</fieldset>
				</fieldset>
			</form>
		</div>
		<a href="#browse" data-role="button" rel="external">BROWSE</a>
		<a href="/beta/jeff-cathay_022614,1958/core/fav/fav.php" rel="external" data-role="button" data-transition="">SUGGESTIONS FOR YOU!</a>
		<a href="/beta/jeff-cathay_022614,1958/core/vote/vote.php?r=1" rel="external" data-role="button" data-transition="">VOTECAST</a>
		<a href="/beta/jeff-cathay_022614,1958/core/giglist.php?h=<?php echo $host; ?>" rel="external" data-role="button" data-transition=""><?php echo $hostUpper; ?>'S OTHER GIGS!</a>
	</div>   
	<?php include('/var/www/html/beta/jeff-cathay_022614,1958/core/assets/footer.php'); ?>
</div>
