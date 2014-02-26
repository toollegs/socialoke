<?php

error_reporting(E_ALL);

include_once('/var/www/html/beta/core/globals.php');

$knownHosts =  getKnownHosts();

$knownVenues = getKnownVenues();

$knownCrumbs = array ("help");

$knownAdmin = array("add","del","msgon","msgoff","remind");

$knownEng = array("sing","reg","list");
$daysofweek = array();
$daysofweek["sun"] = "sun";
$daysofweek["sunday"] = "sun";
$daysofweek["mon"] = "mon";
$daysofweek["monday"] = "mon";
$daysofweek["tue"] = "tue";
$daysofweek["tuesday"] = "tue";
$daysofweek["wed"] = "wed";
$daysofweek["wednesday"] = "wed";
$daysofweek["thu"] = "thu";
$daysofweek["thursday"] = "thu";
$daysofweek["fri"] = "fri";
$daysofweek["friday"] = "fri";
$daysofweek["sat"] = "sat";
$daysofweek["saturday"] = "sat";

if (isset($_GET['fromCrontab']) && $_GET['fromCrontab'] =='yes') {
	doStopForNight();
	exit();
}
$from = $_GET['from'];
$text = $_GET['text'];
$from = strtolower($from);
$text = strtolower($text);
$logstr=getDateForLog()."||".base64_encode($from)."||".$text."\n";
file_put_contents('/usr/logs/mysocialoke/core/searches.log',$logstr, FILE_APPEND | LOCK_EX);
$crumbs = array('fav');
if ($text != null && $text != '') {
	$crumbs = explode(' ',$text);
	foreach($crumbs as $crumb) {
		$crumb = strtolower($crumb);
	}
}
if (in_array($crumbs[0],$knownAdmin)) {
	processAdminReq($from, $crumbs);
	return;
}
if (isset($knownHosts[$crumbs[0]])) {
	processHostReq($from,$crumbs);
	return;
}
echo "crumbs[0]: '".$crumbs[0]."'";
var_dumper($knownVenues);
if (in_array($knownVenues[$crumbs[0]],$knownVenues)) {
	echo "Yay!";
	$crumbs[0] = $knownVenues[$crumbs[0]];
	processCustReq($from,$crumbs,"vo");
}
$first4 = substr($crumbs[0],0,4);
if (in_array($first4,$knownEng)) {
	if (count($crumbs) == 1) {
		$code = substr($crumbs[0],4);
		$crumbs[0] = 'sing';
		$crumbs[1] = $code;
	}
	processCustReq($from,$crumbs,"c");
}
if (in_array($crumbs[0], $knownCrumbs)) {
	doCommands($from,strtolower($venue));
}

function processAdminReq($from,$crumbs)
{
	global $knownVenues, $knownHosts, $daysofweek;

	if ($from != "16179706735" 
	&& $from != "15083205592"
	&& $from != "16178661155"
	&& $from != "18607481198") {
		return;
	}
	switch($crumbs[0]) {
		case "add":

			$cmd = strtolower($crumbs[0]);
			$host = strtolower($crumbs[1]);
			$venue = strtolower($crumbs[2]);
			if (!in_array($venue,$knownVenues)) {
				return;
			}
			$dow = array();
			for ($i=3; $i < count($crumbs)-1; $i++){
				$dow[] = strtolower($crumbs[$i]);
			}
			$ph = strtolower($crumbs[count($crumbs)-1]);
			if (strlen($ph) == 10) {
				$ph = '1'.$ph;
			}
			echo $ph.", ".strlen($ph);
			if (strlen($ph) == 11) {	
				addHost($ph,$venue,$dow,$host);
			} else {
				return;
			}
			break;
		case "del":
			echo "phone: ".$knownHosts[$crumbs[1]].', from: '.$from;
			$admin = isAdmin($from);
			echo "admin: ".$admin;
			if ($admin == 1) {
				echo "calling delHost...";
				delHost($from,$crumbs[1],$knownHosts[$crumbs[1]]);
			} else {
				echo "not admin";
			}
			break;
		case "msgon":
			turnOnMsgng();
			break;
		
		case "msgoff":
			turnOffMsgng();
			break;
		case "remind":
			if (isset($crumbs[1])) {
				$thisHost = $crumbs[1];
				doRemind($thisHost);
			} else {
				doRemind();
			}
			break;
	}
}

function isAdmin($from)
{
	$ret = 1;

	if ($from != "16179706735" 
	&& $from != "15083205592"
	&& $from != "16178661155"
	&& $from != "18607481198") {
		$ret = 0;
	}

	return $ret;
}
	

function addHost($from,$venue,$dow,$host)
{
	global $knownHosts, $daysofweek;

	echo "host: ".$host;
	echo "days: ".var_dumper($dow);

// Check if host with this name already exists, and if so, increment a counter
// until the host no longer exists

	$f = file("/var/www/html/beta/core/knownHosts");
	$gothost = 0;
	$i = '';
	while ($gothost == 0) {
		$changed = 0;
		foreach ($f as $line) {
			if (startsWith($line,$host.",")) {
				if ($i == '') {
					$i = 2;
				} else {
					$i += 1;
				}
				$host = $host.$i;
				$changed = 1;
				break;
			}
		}
		if ($changed == 0) {
			break;
		}
	}
	echo "realHost: ".$host;
	file_put_contents("/var/www/html/beta/core/knownHosts",$host.",".$from.PHP_EOL, FILE_APPEND | LOCK_EX);
	$knownHosts = getKnownHosts();

	file_put_contents("/usr/logs/mysocialoke/giglists/".$host,$venue.PHP_EOL);
	$farr = file("/var/www/html/beta/core/basegiglist");
	foreach($farr as $line) {
		$lineOut = $line;
		foreach($dow as $day) {
			echo "val: ".startsWith($line,$day)." ";
			if (startsWith($line,$day)) {
				$lineOut = $day.','.$venue.PHP_EOL;
			}	
		}
		file_put_contents("/usr/logs/mysocialoke/giglists/".$host,$lineOut,FILE_APPEND | LOCK_EX);
	}
	//createEvent($from,$venue,$host);
//	doSMS($from,$host." added to ".$venue." hosting on ".$dow);
}

function delHost($from,$host,$hostPhone)
{
	global $knownHosts;

	$lines = file("/var/www/html/beta/core/knownHosts");
	unlink("/var/www/html/beta/core/knownHosts");
	foreach($lines as $line) {
		$nv = explode(',',trim($line));
		echo "nv0: ".$nv[0].", host: ".$host.", nv1: ".$nv[1].", from: ".$from."<br/>";
		if (strcmp($nv[0],$host) != 0 || strcmp($nv[1],$hostPhone)) {
			echo "Writing this one...<br/>";
			file_put_contents('/var/www/html/beta/core/knownHosts',$nv[0].','.$nv[1].PHP_EOL, FILE_APPEND | LOCK_EX);
		} else {
			echo "NOT writing this one...<br/>";
		}
	}
	unlink('/usr/logs/mysocialoke/giglists/'.trim($host));
}

	
function createEvent($from,$venue,$host)
{
	echo "In createEvent...";
	global $knownHosts;

	$today = date('mdy');
	$tomorrow = date('mdy',strtotime("+1 day"));
	$code = n_digit_random(4);
	$symLink=$host.'-'.$venue.'_'.$today.','.$code;
	$symLinkTomorrow=$host.'-'.$venue.'_'.$tomorrow.','.$code;
	shell_exec('/var/www/html/beta/scripts/makesite.ksh '.$symLink.' '.$knownHosts[$host]);
	chmod('/var/www/html/beta/'.$symLink,0777);
	symlink('/var/www/html/beta/'.$symLink,'/var/www/html/beta/'.$symLinkTomorrow);

	chmod('/var/www/html/beta/'.$symLinkTomorrow,0777);
	echo "venue: ".$venue;
	symlink('/var/www/html/beta/'.$symLink,'/var/www/html/'.$venue);
	chmod('/var/www/html/'.$venue,0777);
	file_put_contents('/usr/logs/mysocialoke/venuesOn/'.$symLink,'');
	touch('/usr/logs/mysocialoke/votes/'.$symLink);
	symlink('/usr/logs/mysocialoke/venuesOn/'.$symLink,'/usr/logs/mysocialoke/venuesOn/'.$symLinkTomorrow);
	echo "<a href='http://s-oke.com/gig/".$venue."?ph=".base64_encode($from)."'>main link</a>\n<br/>";
	$text = $host." at ".$venue." is now ON. Open this link on your computer to use your dashboard: http://s-oke.com/dboard/".$host;
	echo "<br/>".$text."</br>";

	echo "About to doSMS................";
	if ($from != '16179706735') {
		turnOnMsgng();
	}
	doSMS($from,$text);
	if ($from == '16179706735' && $host != 'jeff') {
		doSMS($knownHosts[$host],$text);
	}
}

function processCustReq($from,$crumbs,$type)
{
	global $knownVenues;
	echo "type: ".$type;

	if ($type === "c") {
		$comp = $crumbs[0];
	} else if ($type === "v") {
		$comp = $crumbs[1];
	} else if ($type === "vo") {
		$comp = $crumbs[0];
	}
	echo "type: ".$type;
	if ($type === 'vo') {
		$venue = $knownVenues[$comp];
	}
	switch ($comp) {
		case "list":
		case "sing":
		case "reg":
			echo "doing reister..";
			doRegister($crumbs,$from);
			break;
		case "song":
		case "songs":
			$venue = $crumbs[0];
			$subArray=array_slice($crumbs,2,count($crumbs)-1);
			$songReq = implode(' ',$subArray);
			echo "songReq: ".$songReq;
			doSongSearch($venue,$from,$songReq);
			break;
		case "artist":
		case "artists":
			$venue = $crumbs[0];
			$subArray=array_slice($crumbs,2,count($crumbs)-1);
			$songReq = implode(' ',$subArray);
			doArtistSearch($venue,$from,$songReq);
			break;
		default:
			echo "venue: ".$venue."<br/>";
			var_dumper($knownVenues);
			if (in_array($venue,$knownVenues)) {
				doRegister($crumbs,$from);
			}
			break;
	}
}


function processHostReq($from,$crumbs)
{
	echo "from: ".$from;
	var_dump($crumbs);
	$host = strtolower($crumbs[0]);
	$venue = strtolower($crumbs[1]);
	if ($venue == 'help') {
		echo "doing help...";
		doHelp($from,$host);
		return;
	}
	switch ($crumbs[2]) {
		case "start":
		case "on":
			doStart($from,$venue,$host);
			break;
		case "stop":
		case "off":
			echo "about to doStop";
			doStop($from,$venue,$host);
			break;
		default:
			break;
	}
}

function doRegister($crumbs,$from)
{
	global $knownVenues;

	$logstr='';
		
	if (count($crumbs) == 2) {
		$code = $crumbs[1];
		$venue = getVenueForHandler($code);
		$venueArr = explode('-',$venue);
		$vtemp = explode('_',$venueArr[1]);
		$venue = $vtemp[0];
		echo "code: ".$code.", venue: ".$venue;
	} else {
		$venue = $knownVenues[$crumbs[0]];
	}
	$fullVenue = getVenueForHandler($venue);
	$fvArr = explode('-',$fullVenue);
	$host = $fvArr[0];
	
	if ($fullVenue != FALSE) {
		$venueOn = isVenueOn($venue);
		echo "venueOn: ".$venueOn;
		if ($venueOn != FALSE) {
			echo $from.": ".$venue." is on, doing sms...";
			$text_parm="Socialoke with ".strtoupper($host)." at ".strtoupper($venue)." begins here: ";
			$text_parm.="http://s-oke.com/gig/".$venue."?ph=".base64_encode($from);
			doSMS($from,$text_parm);
			$logstr=getDateForLog()."||".base64_encode($from)." registered with ||".getVenueForHandler($venue);
			$logstr.="\n";
		}
	} else {
		echo $venue." is NOT on!";
	}
	file_put_contents('/usr/logs/mysocialoke/core/msgng/registered.log',$logstr, FILE_APPEND | LOCK_EX);
	doOutput($logstr);
}

function doSongSearch($venue,$from,$songReq)
{	
	$text = '';
	$fullVenue = getVenueForHandler($venue);
	if ($fullVenue != FALSE) {
		$text = "SEARCH RESULTS FOR SONG ".strtoupper($songReq).": http://s-oke.com/beta/".$fullVenue."/core/songs/songs.php?q=".urlencode($songReq)."&ph=".base64_encode($from);
		echo $text;

		doSMS($from,$text);
		echo $from." searched song ".$songReq." at ".$venue."<br/>";
	} else {
		echo $venue." not available!";
	}
}

function doArtistSearch($venue,$from,$songReq)
{
	echo $from." searched ".$songReq." at ".$venue."<br/>";
	$fullVenue = getVenueForHandler($venue);
	if ($fullVenue != FALSE) {
		$text = "SEARCH RESULTS FOR ARTIST ".strtoupper($songReq).": http://s-oke.com/beta/".$fullVenue."/core/artist/artists.php?q=".urlencode($songReq)."&ph=".base64_encode($from);
		echo $text;

		doSMS($from,$text);
		echo $from." searched artist ".$songReq." at ".$venue."<br/>";
	} else {
		echo $venue." not available!";
	}
	
}

function doStart($from,$venue,$host)
{
	global $knownHosts, $knownVenues;

	if ($knownHosts[$host] == $from || $from == '16179706735') {
		if (in_array($venue,$knownVenues)) {
			createEvent($from,$knownVenues[$venue],$host);
		}
	}
}

function dropEvent($from,$venue,$host)
{
	$symLink=$host.'-'.$venue;
	$ret = shell_exec('ls /usr/logs/mysocialoke/venuesOn/'.$symLink.'* | head -1');
	if ($ret == null || $ret == '') {
		echo "Venue not on: ".$venue." for ".$host;
		return;
	}
	shell_exec('mkdir -p /usr/logs/mysocialoke/archives/'.$symLink);
	$retArr = explode('/',$ret);
	$realRet = trim($retArr[count($retArr)-1]);
	echo "first ret: ".$realRet;
	$f = file(trim($ret));
	if ($f == null || count($f) == 0) {
		file_put_contents('/usr/logs/mysocialoke/archives/'.$symLink.'/'.$realRet,"NO RESULTS",FILE_APPEND | LOCK_EX);
	} else {
		foreach ($f as $line) {
			echo "line: ".$line;
			echo "the file:<br/>/usr/logs/mysocialoke/archives/".$symLink."/".$realRet;
			file_put_contents('/usr/logs/mysocialoke/archives/'.$symLink.'/'.$realRet,$line,FILE_APPEND | LOCK_EX);
		}
	}
	$vfnArr = explode('_',$realRet);
	$vfn='/usr/logs/mysocialoke/archives/'.$symLink.'/votes.'.$vfnArr[1];
	if (!file_exists('/usr/logs/mysocialoke/votes/'.$realRet.'.log')) {
		file_put_contents($vfn,"NO RESULTS",FILE_APPEND | LOCK_EX);
	} else {
		$f = file('/usr/logs/mysocialoke/votes/'.$realRet.'.log');
		foreach ($f as $line) {
			file_put_contents($vfn,$line,FILE_APPEND | LOCK_EX);
		}
	}
	$ret = shell_exec('rm -rf /usr/logs/mysocialoke/votes/'.$realRet.'.log');
	$ret = shell_exec('rm -rf /var/www/html/beta/'.$symLink.'*');
	$ret = shell_exec('rm -rf /usr/logs/mysocialoke/venuesOn/'.$symLink.'*');
	unlink('/var/www/html/'.$venue);
	doSMS($from,$host." at ".$venue." is now OFF");
}

function doStop($from,$venue,$host)
{
	global $knownHosts, $knownVenues;

	echo 'venue: '.$venue.', host: '.$host;	
	if ($knownHosts[$host] == $from || $from == '16179706735') {
		if (in_array($venue,$knownVenues)) {
			echo "ima drop it like its hot!";
			dropEvent($from,$venue,$host);
		}
	}
}

function doStopForNight()
{
	$files = glob('/usr/logs/mysocialoke/venuesOn/*'); // get all file names
	foreach($files as $file){ // iterate files
		if(is_file($file)) {
    			unlink($file); // delete file
		}
	}
}

function doHelp($from,$venue)
{
	switch($from)
	{
		case "15083205592":
			$comm="admin: add <h> <v> <ph>, del <h> <v> <ph>, host: dan <v> on, dan <v> off; customer: <v> list, <v> song <string>, <v> artist <string>";	
			break;
		case "18607481198":
			$comm="admin: add <h> <v> <ph>, del <h> <v> <ph>, host: pam <v> on, pam <v> off; customer: <v> list, <v> song <string>, <v> artist <string>";	
			break;
		case "16179706735": 
			$comm="admin: add <h> <v> <ph>, del <h> <v> <ph>, host: jeff <v> on, jeff <v> off; customer: <v> list, <v> song <string>, <v> artist <string>";	
			break;
		case "16178661155":
			$comm="admin: add <h> <v> <ph>, del <h> <v> <ph>, host: rob <v> on, rob <v> off; customer: <v> list, <v> song <string>, <v> artist <string>";	
			break;
		default:
			$comm=$venue." followed by list, song <string>, artist <string>";	
			break;

	}
	doSMS($from,$comm);
}

function turnOnMsgng()
{
	$ret = shell_exec('find -L /var/www/html/beta -name globals.php | xargs -n 100');
	$retArr = explode(' ',$ret);
	foreach ($retArr as $fn) {
		$fStr = file_get_contents(trim($fn));
		$fStr = str_replace("\$nosms=1;","\$nosms=0;",$fStr);
		file_put_contents(trim($fn),$fStr);
	}
}


function turnOffMsgng()
{
	$ret = shell_exec('find -L /var/www/html/beta -name globals.php | xargs -n 100');
	$retArr = explode(' ',$ret);
	var_dumper($retArr);
	foreach ($retArr as $fn) {
		$fStr = file_get_contents(trim($fn));
		echo "instr: ".$fStr."<br/>";
		$fStr = str_replace("\$nosms=0;","\$nosms=1;",$fStr);
		echo "outstr: ".$fStr."<br/>";
		file_put_contents(trim($fn),$fStr);
	}
}

function doRemind($thisHost)
{
	global $knownHosts;
	$dow = strtolower(date('D'));
	$hour = date('G');
	$files = glob('/usr/logs/mysocialoke/giglists/*'); // get all file names
	$who = array();
	foreach($files as $file){ // iterate files
		$f = file($file);
		for ($i = 1; $i < count($f); $i++) {
			$lineArr = explode(',',$f[$i]);
			$lineArr = array_map("trim",$lineArr);
			if ($lineArr[0] == $dow) {
				if (count($lineArr) == 3  && is_numeric($lineArr[2])) { 
					$thisTime = $lineArr[2];
					$thisH = $thisTime;
					$thisM = 0;
					if (strlen($thisTime) == 4) {
						$thisH = substr($thisTime,0,2);
						$thisM = substr($thisTime,2);
					}
					$gTime = (intval($thisH)*100)+intval($thisM);
					$reminderTime = $gTime - 100;
					$reminderHour = substr($reminderTime,0,2);
					$reminderMin = substr($reminderTime,2);
					if ($reminderTime < 0) {
						$reminderTime = 2300 + $thisM;
					}
					echo "intime: ".$lineArr[2].", gTime: ".$gTime.", rTime: ".$reminderTime.", rHour: ".$reminderHour.", rMin: ".$reminderMin.", thisH: ".$thisH.", thisM: ".$thisM.", rt: ".$reminderTime.": ";
					$nowH = date('G');
					echo "nowH: ".$nowH.", rHour: ".$reminderHour."<br/>";
					if ($nowH == $reminderHour + 1) {
						$fn = explode('/',$file);
						$who[$fn[count($fn)-1]] = $lineArr[1];
						echo "Sending reminder for ".$file."<br/>";
					} else {
						echo "Not sending reminder for ".$file."<br/>";
					}
				}
			}
		}

	}
	foreach($who as $host => $gig) {
		echo "host: ".$host.", gig: ".$gig."<br/>";
		$files = glob('/usr/logs/mysocialoke/venuesOn/".$host."*'); // get all file names
		var_dumper($files);
		$fc = count(glob('/usr/logs/mysocialoke/venuesOn/'.$host.'*'));
		echo "count: ".$fc."<br/>";
		if ($fc > 0) {
			echo $host."'s gig is on at ".$gig."<br/>";
			unset($who[$host]);
		} else {
			if (!isset($thisHost) || $thisHost == null || $thisHost === '' || $thisHost === $host) {
				$id = doSMS($knownHosts[$host],"To turn on Socialoke from your computer for tonight's gig at ".$gig.", click the Start button on your dashboard at http://s-oke.com/dboard/".$host);
				echo "reminding ".$host." to turn on!<br/>";
			}
		}
		file_put_contents("/usr/logs/mysocialoke/reminders",getDateForLog().": Sent to ".$host." for ".$gig.PHP_EOL,FILE_APPEND | LOCK_EX);
	}
	var_dumper($who);
}
