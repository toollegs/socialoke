<html>
<head><title>Vote Cast!</title>
<body>
<?php
include '/var/www/html/beta/core/globals.php';
$uri = startPage('votecast');
$votes = $_POST;
$host = $uri['host'];
$ph = session_get('ph');
writeVotes($uri['fullvenue'],$ph,$votes);
echo "<center>YOUR VOTES HAVE BEEN CAST!</center>";
?>
<h3><a href="/beta/core/login.php?r=1&ph=<?php echo urlencode($ph); ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
<div style="text-align:center"><a href="../giglist.php?h=<?php echo $host; ?>&ph=<?php echo $ph; ?>" rel="external" data-role="button">See My Upcoming Gigs!</a></div>
<a href="http://www.gorhamproductions.com" rel="external" ><img src="../assets/logo-trans.png" width="300" height="115" ></a>
<div data-role="footer" data-theme="f">
	<div style="text-align:center"> <a href="https://www.facebook.com/socialoke" rel="external"><img src="../assets/socialoke.jpg" width="36" height="36"></a><br />Like Us
        </div>
</div>
</body>
</html>
