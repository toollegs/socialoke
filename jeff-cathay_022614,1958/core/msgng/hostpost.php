<?php

include_once('/var/www/html/beta/core/globals.php');

$uri = startPage("hostpost");
$code = $_POST['code'];
echo "code: ".$code."<br/>";
$phEnc=$_POST['ph'];
echo "phEnc: ".$phEnc."<br/>";
$host=$_POST['h'];
echo "h: ".$host."<br/>";
$msg=$_POST['msg'];
echo "msg: ".$msg."<br/>";
$cmsg=$_POST['cmsg'];
echo "customer msg: ".$cmsg."<br/>";
$ph=base64_decode($phEnc);
echo "phEnc: ".$phEnc."<br/>";
$ret=doSMS($ph,"YOU: ".trim($cmsg)." -- ".strtoupper($host).": ".trim($msg));
$key=$_POST['key'];
//addResponse($phEnc,$host,$key,$code,$msg);
//echo "ret: ".$ret;
?>

<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://GorhamProductions.com/karaoke/themes/GorhamPro.min.css" /> <?php echo file_get_contents('http://s-oke.com/beta/core/assets/jquery-include.php'); ?>
<meta http-equiv="refresh" content="5; url=../main.php?ph=<?php echo session_get('ph'); ?>">
</head>
<body>
<h3>Sent *<?php echo $msg ?>* to <?php echo $_POST['n'] ?></h3>
<button type="button" onclick="javascript:window.close();">CLOSE</button>
</body>
</html>
