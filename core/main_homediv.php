<div data-role="page" id="home" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1>SOCIALOKE</h1>
	</div>
	<div data-role="content" data-theme="f">	
		<p style="text-align:center; margin-top: 2px;"> Please select an option below to start exploring our gigantic song collection! </p>
		<a href="#browse" data-role="button" rel="external">BROWSE SONGBOOK</a>
		<a href="#search" data-role="button" rel="external">SEARCH SONGBOOK</a>
		<a href="/beta/core/vote/vote.php?r=1" rel="external" data-role="button" data-transition="">VOTECAST</a>
		<a href="/beta/core/giglist.php?h=<?php echo $host; ?>" rel="external" data-role="button" data-transition=""><?php echo $hostUpper; ?>'S OTHER GIGS!</a>
	</div>   
	<?php include('/var/www/html/beta/core/assets/footer.php'); ?>
</div>
