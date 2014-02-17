<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://www.gorhamproductions.com/karaoke/themes/GorhamPro.min.css"><link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css"><script src="http://code.jquery.com/jquery-1.9.1.min.js"></script><script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
        $('input[id^=l]').click(function(){
		if ($(this).is(':checked')) {
			$(this).val('on');
			var hid = $(this).attr('id');
			hid = hid.substring(1);
			$('input[id="h'+hid+'"]').val('on');
		} else {
			$(this).val('off');
			var hid = $(this).attr('id');
			hid = hid.substring(1);
			$('input[id="h'+hid+'"]').val('off');
		}
        });
});
</script>
</head>
<?php include '/var/www/html/beta/jeff-cathay_021714,1400/core/globals.php';

$url=startPage("vote");
$ph=session_get("ph");
$host=$url['host'];

function getTblItems()
{
	global $url, $ph;
	$fn = '/usr/logs/mysocialoke/votes/'.$url['fullvenue'].'.log';
	$allfn = '/usr/logs/mysocialoke/venuesOn/'.$url['fullvenue'];
	$ret = '';
		
	$fArr = file($fn);
	$allfArr = file($allfn);

	if ($allfArr != null && count($allfArr) > 0) {
		$ret .= '<table width=80% align=center>';
		$i = 0;
				
		$votes = array();
		foreach ($allfArr as $line) {
			$lineArr = explode('||',$line);
			$name = $lineArr[2];
			$name = str_replace("[","(",$name);
			$name = str_replace("]",")",$name);
			$song = $lineArr[3];
			$song = str_replace("[","(",$song);
			$song = str_replace("]",")",$song);
			$key = str_replace('.','',$ph.'||'.$name.'||'.$song);
			$votes[$key] = 'off';
		}
		if ($fArr != null && count($fArr) > 0) {
			foreach ($fArr as $line) {
				$lineArr = explode('||',$line);
				$name = $lineArr[2];
				$name = str_replace("[","(",$name);
				$name = str_replace("]",")",$name);
				$song = $lineArr[3];
				$song = str_replace("[","(",$song);
				$song = str_replace("]",")",$song);
				$key = str_replace('.','',$ph.'||'.$name.'||'.$song);
				$vote = trim($lineArr[4]);
				$votes[$key] = $vote;
			}
		}
		foreach ($votes as $key => $val) {
			$checked = '';
			if (trim($votes[$key]) == 'on') {
				$checked = ' checked';
			}
			$keyArr = explode('||',$key);
			$name=$keyArr[1];
			$song=$keyArr[2];
			$songArr = explode(' by ',$song);
			$songPiece = firstlast($songArr[0]);
			$artistPiece = firstlast($songArr[1]);
			$ret .= '<tr><td width=100%><label for="l'.$i.'" style="text-align:center;">'.$name.' ~~ '.$songPiece.' by '.$artistPiece.'</label><input type="checkbox" id="l'.$i.'" name="'.$key.'" value="'.$votes[$key].'"'.$checked.'/><input type="hidden" id="h'.$i.'" name="'.$key.'" value="'.$votes[$key].'"/></td></tr>';
			$i = $i + 1;
		}
		$ret .= "</table>";
		$ret .= '<div id="saveBtn"><input type=submit value="VOTE!"/></div>';
	} else {
		$ret = "<center>No WiFi Karaoke singers yet</center>";
	}	
	return $ret;
}
?>

<body> 
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div data-role="page" id="home" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
    		<h1>VOTECAST</h1>
	</div>
	<div data-role="content" data-theme="f">	
		<div id="voteDiv">
		<form method=POST action="votecast.php">
		<?php echo getTblItems(); ?>
		</form>
		</div>
	</div>
	<div id="back-button" class="centerer">
                <h3><a href="/beta/jeff-cathay_021714,1400/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        </div>
	<?php echo file_get_contents('../assets/footer.php'); ?>
</div>

</body></html>
