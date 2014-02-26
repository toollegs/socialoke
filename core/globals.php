<?php

$nosms=1;
$destphones='16179706735';

function getKnownHosts()
{
	$hostsFromFile = file("/var/www/html/beta/core/knownHosts");
	$knownHosts = array();
	foreach($hostsFromFile as $hostph) {
		$hostArr = explode(',',$hostph);
		$knownHosts[trim($hostArr[0])] = trim($hostArr[1]);
	}
	return $knownHosts;
}

function getKnownVenues()
{
	$venuesFromFile = file("/var/www/html/beta/core/knownVenues");
	$knownVenues = array();
	foreach($venuesFromFile as $venues) {
		$venuesArr = explode(',',$venues);
		foreach($venuesArr as $venue) {
			$knownVenues[trim($venue)] = trim($venuesArr[0]);
			$knownVenues[trim($venue).'-lnk'] = trim($venuesArr[count($venuesArr)-1]);
		}
	}
	return $knownVenues;
}

function var_dumper($obj)
{
	echo "<pre>".var_dump($obj)."<pre>";
}

function writeNewKnownHost($hostph)
{
	file_put_contents("/var/www/html/beta/core/knownHosts",$hostph.PHP_EOL, FILE_APPEND | LOCK_EX);
}

function createURIPieceMap()
{
	global $uriPieceMap;
	
	$ret = array();
	$uri = $_SERVER['REQUEST_URI'];
	$ret["uri"] = $uri;
	$uri_arr = explode('/',$uri);
	$ret["base"] = $uri_arr[1];
	$ret["fullvenue"] = $uri_arr[2];
	$fullVenueArr = explode('-',$ret["fullvenue"]);
	$ret['host'] = $fullVenueArr[0];
	$venuePlusDatePlusCode = explode('_',$fullVenueArr[1]);
	$ret['venue'] = $venuePlusDatePlusCode[0];
	$dateCodeArr = explode(',',$venuePlusDatePlusCode[1]);
	$ret['date'] = $dateCodeArr[0];
	$ret['code'] = $dateCodeArr[1];

	return $ret;
}

function startsWith($haystack, $needle)
{
    return !strncmp($haystack, $needle, strlen($needle));
}

function endsWith($haystack, $needle)
{
	$length = strlen($needle);
	if ($length == 0) {
		return true;
    	}

	return (substr($haystack, -$length) === $needle);
}

function firstlast($s)
{
	$ret = $s;
	$strArr = explode(',',$s);
	if (count($strArr) > 1) {
		$ret = trim($strArr[1]).' '.trim($strArr[0]);
	}
	return $ret;
}

function doSMS($to, $msg)
{
	global $nosms;
	if ($nosms == 0) {
		$sms_host="api.clickatell.com";
		$sms_api_type="http";
		$sms_func="/sendmsg";
		$user_parm="user=toollegs";
		$password_parm="password=Dec261967";
		$api_id_parm="api_id=3336349";
		$from_parm="from=19012015285";
		$mo_parm="mo=1";
		$to_parm="to=".urldecode($to);
		$text_parm="text=".urlencode($msg);
		$query=$user_parm."&".$password_parm."&".$api_id_parm."&".$from_parm."&".$mo_parm."&".$to_parm."&".$text_parm;
		$url="http://".$sms_host."/".$sms_api_type."/".$sms_func."?".$query;
		$ret = file($url);
		var_dumper($ret);
	} else {
		$ret = "not sending sms";
	}

	return $ret;
}

function doOutput($text)
{
	echo $text."\n";
}

function createPath($path) {
    if (is_dir($path)) return true;
    $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
    $return = createPath($prev_path);
    return ($return && is_writable($prev_path)) ? mkdir($path) : false;
}

function addToHistory($venue,$t,$noteKey)
{
	$fromMO = session_get('ph');
	if ($fromMO == null || $fromMO == '' || $fromMO == 'none') {
		$fromMO = n_digit_random(10);
	};

	$tArr = explode('||',$t);
	$song = $tArr[1];
	$song = str_replace(' - ', ' by ',$t);
	$song = str_replace('%26', '&',$t);

	$histStr=getDateForLog().'||'.$fromMO.'||'.$song;
	if (isset($noteKey)) {
		$histStr .= '||http://s-oke.com/ho/'.$noteKey;
	}

	$hvArr=explode('_',$venue);
	$hv = $hvArr[0];
	$histStr = str_replace('&amp;','&',str_replace('&apos;',"'",$histStr));

	if ($fromMO != null && $fromMO != '') {	
		file_put_contents('/usr/logs/mysocialoke/venuesOn/'.$venue,$histStr.PHP_EOL, FILE_APPEND | LOCK_EX);
		addToFavs($venue,$tArr[1]);
	}
}

function addToFavs($venue,$song)
{
	$fromMO = session_get('ph');
	if ($fromMO == null || $fromMO == '' || $fromMO == 'none') {
		$fromMO = n_digit_random(10);
	};
	$favStr=$fromMO."||".str_replace(' - ',' by ',$song);
	$favStr=$fromMO."||".str_replace('%26','&',$song);
	$favStr = str_replace('&amp;','&',str_replace('&apos;',"'",$favStr));
	$hvArr=explode('_',$venue);
	$hv = $hvArr[0];
	if ($fromMO != null && $fromMO != '') {	
		file_put_contents('/usr/logs/mysocialoke/favs/favs.'.$hv,$favStr.PHP_EOL, FILE_APPEND | LOCK_EX);
	}
}

function session_put($n,$v)
{
	$_SESSION[$n] = $v;
}

function session_get($n)
{
	if(isset($_SESSION[$n]) && !empty($_SESSION[$n])) {
		return $_SESSION[$n];
	} else {
		return null;
	}
}

function stopBack()
{
	if(isset($_SESSION['noback']) && !empty($_SESSION['noback'])) {
		unset($_SESSION['noback']);
		goHome();
	}
}

function goHome()
{
	header('Location: http://mysocialoke.com/beta/'.getEventUri().'/core/main.php');
}

function startPage($func)
{
	error_reporting(E_ERROR);
	#error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	session_start();
	
	return createURIPieceMap();
}

function getVenueForHandler($venue)
{
	$files = glob('/usr/logs/mysocialoke/venuesOn/*'.$venue.'*');
	if ($files != null && $files != FALSE && count($files) > 0) {
		$filesArr = explode('/',$files[0]);
		$ret = $filesArr[count($filesArr)-1];
		return $ret;
	}

	return FALSE;
}

function dumpSession($func)
{
	echo "Session data: ";
	echo $func.' ';

	print_r($_SESSION);
}

function isVenueOn($venue)
{
	$files = glob('/usr/logs/mysocialoke/venuesOn/*'.$venue.'*');
	$ret = FALSE;
	if ($files != null && count($files) > 0) {
		$ret = TRUE;
	}

	return $ret;
}

function alreadyRegistered($venue,$from)
{
	$retVal = FALSE;
	$lines = file('/usr/logs/mysocialoke/venuesOn/'.getVenueForHandler($venue));
	foreach($lines as $line) {
		echo "line: ".$line.", from: ".$from;
		$number = strstr($line,base64_encode($from));
		if ($number != FALSE) {
			$retVal = TRUE;
		} else {
			$retVal = FALSE;
		}
	}

	echo "alreadyRegistered returning: ".$retVal;
	
	return $retVal;
	
}

function addJQuery($dom) {
	$headNode = $dom->getElementsByTagName('head')->item(0);
	$script = $dom->createElement('script');
	$script->setAttribute('src','../ui-funcs.js');
	$headNode->appendChild($script);
}

function n_digit_random($digits)
{
	return rand(pow(10, $digits - 1) - 1, pow(10, $digits) - 1);
}

function addNote($fromMO,$name,$host,$code,$t)
{
	echo "addNote phone: ".$fromMO.", ".base64_decode($fromMO);
	$key = $code."-".n_digit_random(10);
	file_put_contents("/usr/logs/mysocialoke/notes/".$code,$key.'||'.$fromMO.'||'.$name.'||'.$host.'||'.$code.'||'.$t.PHP_EOL,FILE_APPEND | LOCK_EX);

	return $key;
}

function addResponse($fromMO,$host,$key,$code,$msg)
{
	$outstr = $key.'||'.$fromMO.'||'.$host.'||'.$code.'||'.$msg.PHP_EOL;
	echo "outstr: ".$outstr." to /usr/logs/mysocialoke/notes/".$code;
	file_put_contents("/usr/logs/mysocialoke/notes/".$code,$outstr,FILE_APPEND | LOCK_EX);

	return $key;
}

function writeVotes($venue,$ph,$votes)
{
	$dir = '/usr/logs/mysocialoke/votes/'.$venue;
	if (!file_exists($dir)) {
		touch($dir);
	}
	foreach ($votes as $key => $val) {
		$key = trim($key);
		$val = trim($val);
		$date = getDateForLog();
		file_put_contents($dir.'.log',$date.'||'.str_replace('_',' ',$key).'||'.$val.PHP_EOL,FILE_APPEND | LOCK_EX);
	}
}

function getUserCount($venue)
{
	$i = 0;

	$vArr = explode(',',$venue);
	$vCode = '||'.getVenueForHandler($venue);
	$f = file('/usr/logs/mysocialoke/core/msgng/registered.log');
	foreach ($f as $line) {
		if (strpos($line,$vCode)) {
			$i = $i + 1;
		}
	}

	return $i;
}

function getFullVenue($uri)
{
	$uri = trim($uri);
	$uriArr = explode('/',$uri);
	var_dump($uriArr);
	$ret = getVenueForHandler($uriArr[1]);

	return $ret;
}

function getDateForLog()
{
	return date('Ymd His O');
}

function getHostPhone($host)
{
	$kHosts = getKnownHosts();
	
	return $kHosts[$host];
}

function doCustBranding($custid)
{

// TBD
/*
	if (!isset($custid) || $custid === '') {
		return '<div id="host-logo" style="display:inline;"><a href="http://www.gorhamproductions.com" rel="external"><img src="http://www.gorhamproductions.com/wp-content/uploads/2011/06/Gorham-Productions-logo.jpg" width="150" height="58"></a></div>';
	}
*/
}

function doSocialokeBranding()
{
	return '<div id="fb-like" style="display:inline;"><a href="https://www.facebook.com/socialoke" rel="external"><img src="/beta/core/assets/socialoke-likeus.png" width="58" height="58"></a></div>';
}
