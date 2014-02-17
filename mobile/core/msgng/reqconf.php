<?php

include '/var/www/html/beta/core/globals.php';

$url = startPage("reqconf");
$host = $url['host'];
$code = $url['code'];
$name_parm=$_POST['name'];
$rnd = n_digit_random(7);
if ($name_parm != null && $name_parm != '') {
	$text = $_POST['t'];
	$fromMO=session_get('ph');
	$textArr = explode(' by ',$text);
	$songArr = array();
	$songArr[0] = str_replace('%26','&',firstlast($textArr[0]));
	$songArr[1] = str_replace('%26','&',firstlast($textArr[1]));
	$rText = $songArr[0]." by ".$songArr[1];
        $text = $name_parm." will be singing ".$rText;
} else {
//        header('Location: /beta/core/expired.php?u='.$url['fullvenue']);
//        exit();
}
$textForHost = $text;
$flirt=$_POST['flirt'];
if ($flirt != null && $flirt != '') {
        $flirt = str_replace("'","",$flirt);
        $text .= ". You sent this note to ".ucfirst($host).": ".$flirt;
	$key = addNote($fromMO,$name_parm,$host,$code,$flirt);
}
if ($flirt != '') {
	$textForHost .= " Read Note: http://s-oke.com/ho/".$key;
}
#$textForHost = $text." Respond: http://s-oke.com/ho?ph=".$fromMO."&name=".$name_parm."&h=".$host;
$realPH = base64_decode($fromMO);
$venue = $url['fullvenue'];
$smsRet = "None";
if (isVenueOn($venue)) {
        $smsRet = "smsRet: ".doSMS($destphones,$textForHost);
}
?>
<html>
<head>
<meta charset="UTF-8">
<title>Gorham Productions</title>
<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="http://www.GorhamProductions.com/karaoke/themes/GorhamPro.min.css" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>
<body>
<div data-role="page" id="home" data-theme="f">
        <div data-role="header" data-position="fixed" data-theme="f">
                <h1>WIFI KARAOKE</h1>
<?php echo $err; ?>
        </div>
        <div data-role="content"  data-theme="f">
		<h3><?php echo $text ?></h3>
		<h3><a href="/beta/core/login.php?r=1&ph=<?php echo $fromMO; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
		<a href="http://www.gorhamproductions.com" rel="external" ><img src="../assets/logo-trans.png" width="300" height="115" ></a>
                <div data-role="footer" data-theme="f">
                        <div style="text-align:center"> <a href="https://www.facebook.com/socialoke" rel="external"><img src="../assets/socialoke.jpg" width="36" height="36"></a><br />Like Us
                </div>
        </div>
</div>
</body>
</html>
<?php

$t4Url = $name_parm."||";
$t4Url .= $_POST['t'];
if (isset($flirt)) {
	$t4Url .= "||".$flirt;
}
addToHistory($url['fullvenue'],$t4Url,$key);
?>
