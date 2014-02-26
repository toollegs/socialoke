<?php

include_once('/var/www/html/beta/jeff-cathay_022614,1958/core/globals.php');

$url = startPage("reqconf");
$host = $url['host'];
$code = $url['code'];
$name_parm=$_POST['name'];
$rnd = n_digit_random(7);
if ($name_parm != null && $name_parm != '') {
	$text = $_POST['t'];
	$ph=session_get('ph');
	$text = urldecode($text);
	$textArr = explode(' by ',$text);
	$songArr = array();
	$songArr[0] = firstlast($textArr[0]);
	$songArr[1] = firstlast($textArr[1]);
	$rText = str_replace('&amp;','&',str_replace('&apos;',"'",$songArr[0]." by ".$songArr[1]));
        $text = $name_parm." will be singing ".$rText;
} else {
        header('Location: /beta/jeff-cathay_022614,1958/core/expired.php?u='.$url['fullvenue']);
        exit();
}
$textForHost = $text;
$flirt=$_POST['flirt'];
if ($flirt != null && $flirt != '') {
        $flirt = str_replace("'","",$flirt);
        $text .= ". You sent this note to ".ucfirst($host).": ".$flirt;
}
$key = addNote($ph,$name_parm,$host,$code,$flirt);
if ($flirt != '') {
	$textForHost .= " Read Note: http://s-oke.com/ho/".$key;
}
$realPH = base64_decode($ph);
$venue = $url['fullvenue'];
$smsRet = "None";
if (isVenueOn($venue)) {
        $smsRet = "smsRet: ".doSMS($destphones,$textForHost);
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://GorhamProductions.com/karaoke/themes/GorhamPro.min.css" /> <?php echo file_get_contents('http://s-oke.com/beta/jeff-cathay_022614,1958/core/assets/jquery-include.php'); ?>
</head>
<body>
<div data-role="page" id="home" data-theme="f">
        <div data-role="header" data-position="fixed" data-theme="f">
                <h1>WIFI KARAOKE</h1>
<?php echo $err; ?>
        </div>
        <div data-role="content"  data-theme="f">
		<h3><?php echo $text ?></h3>
        </div>
	<div id="back-button" class="centerer">
                <h3><a href="/beta/jeff-cathay_022614,1958/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        </div>
	<?php include_once('/var/www/html/beta/jeff-cathay_022614,1958/core/assets/footer.php'); ?>
<?php

$t4Url = $name_parm."||";
$t4Url .= urldecode($_POST['t']);
if (isset($flirt)) {
	$t4Url .= "||".$flirt;
}
addToHistory($url['fullvenue'],$t4Url,$key);
?>
</div>
</body>
</html>
