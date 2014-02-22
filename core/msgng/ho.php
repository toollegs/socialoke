<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://GorhamProductions.com/karaoke/themes/GorhamPro.min.css" /> <?php echo file_get_contents('http://s-oke.com/beta/core/assets/jquery-include.php'); ?>
</head>
<body>
<div data-role="page" id="home" data-theme="f">
<?php

include '/var/www/html/beta/core/globals.php';

	$key = $_GET['key'];
	$keyArr = explode('-',$key);
	$f = file('/usr/logs/mysocialoke/notes/'.$keyArr[0]);
	if (count($f) > 0) {
		foreach($f as $line) {
			$fArr = explode('||',$line);
			$thisKey = $fArr[0];
			if ($thisKey == $key) {
				$fromMO=trim($fArr[1]);
				$name=trim($fArr[2]);
				$host=trim($fArr[3]);
				$code=trim($fArr[4]);	
				if (isset($fArr[5])) {
					$msg=trim($fArr[5]);
				}
				break;
			}
		}
//	}
?>
<form method=POST action=/beta/core/msgng/hostpost.php>
<input type="hidden" name="h" value="<?php echo $host ?>"/>
<input type="hidden" name="n" value="<?php echo $name ?>"/>
<input type="hidden" name="ph" value="<?php echo $fromMO ?>"/>
<input type="hidden" name="key" value="<?php echo $key ?>"/>
<input type="hidden" name="code" value="<?php echo $code ?>"/>
<input type="hidden" name="cmsg" value="<?php echo trim($msg); ?>"/>
<?php
	if (!isset($msg) || $msg == '') {
		$msg = $name." did not send a Note To Host";
	} else { 
		$msg = $name.' said: "'.trim($msg).'"';
	}
?>	
<h3><?php echo $msg ?></h3>
Text back to <?php echo $name?>: <input type="text" name="msg" size="101" maxlength="100"/>
<input type=submit value="GO!"/>
</form>
<?php
	} else {
?>
<h3>SORRY!</h3>
<?php
	}
?>
</div>
</body>
</html>
