<?php

include '/var/www/html/beta/core/globals.php';

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
$ret=doSMS($ph,"You said: ".trim($cmsg).",".ucfirst($host)." says: ".trim($msg));
$key=$_POST['key'];
//addResponse($phEnc,$host,$key,$code,$msg);
//echo "ret: ".$ret;
?>

<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://www.gorhamproductions.com/karaoke/themes/GorhamPro.min.css"><link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css"><script src="http://code.jquery.com/jquery-1.9.1.min.js"></script><script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script><script src="/beta/jquery-1.10.2.min.js"></script>
<meta http-equiv="refresh" content="5; url=../main.php?ph=<?php echo session_get('ph'); ?>">
</head>
<body>
<h3>Sent *<?php echo $msg ?>* to <?php echo $_POST['n'] ?></h3>
<button type="button" onclick="javascript:window.close();">CLOSE</button>
</body>
</html>
