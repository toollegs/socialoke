<?php

include '/var/www/html/playground/mobile/core/globals.php';
error_reporting(E_ERROR);

$songs = file('/var/www/html/playground/mobile/core/songs/all.csv');
$jSongs = array();
foreach ($songs as $jSong) {
	$jSongArr = explode(' - ',trim($jSong));
	$thisOne = array();
	$thisOne["s"] = trim($jSongArr[0]);
	$thisOne["a"] = trim($jSongArr[1]);
	$jSongs[strtolower($thisOne["a"].' - '.$thisOne["s"])] = $thisOne;
}

function get_all()
{
	global $jSongs;

	if (file_exists('songs.json')) {
		unlink('songs.json');	
	}
	file_put_contents('songs.json',json_encode($jSongs),FILE_APPEND | LOCK_EX);	
##	echo json_encode($jSongs);
}
	
function get($s,$a)
{
	$json = file_get_contents('songs.json');
	$o = json_decode($json,true);
	$ret = array();
	$i = 0;
	foreach($o as $song) {
		$found = false;
		if (isset($s) && $s !== '') {
			if (strpos(strtolower($song['s']),strtolower($s)) !== false) {
				$found = true;
			} else {
				$found = false;
			}
		}
		if (isset($a) && $a != '') {
			if (strpos(strtolower($song['a']),strtolower($a)) !== false) {
				$found = true;
			} else {
				$found = false;
			}
		}
		if ($found == true) {
			$ret[] = $song;
		}
	}
	$ret = array_map("unserialize", array_unique(array_map("serialize", $ret)));
	sort($ret);
	var_dumper($ret);
}

function popular()
{
	$json = file_get_contents('songs.json');
	$o = json_decode($json,true);
	$ret = array();
	foreach($o as $song) {
		var_dumper($song);
		continue;
		if ($song['p'] == 1) {
			$ret[] = $song;
		}
	}
	$ret = array_map("unserialize", array_unique(array_map("serialize", $ret)));
	sort($ret);
	var_dumper($ret);
}

function duets()
{
	$json = file_get_contents('songs.json');
	$o = json_decode($json,true);
	$ret = array();
	foreach($o as $song) {
		if ($song['d'] == 1) {
			$ret[] = $song;
		}
	}
	$ret = array_map("unserialize", array_unique(array_map("serialize", $ret)));
	sort($ret);
	var_dumper($ret);
}

function setgenres()
{
	$json = file_get_contents('songs.json');
	$o = json_decode($json,true);

	header("Content-type: text/html");
	echo "<html><head><title>Socialoke Song Editor</title></head>";
	echo '<body><form method=POST action=editsongs.php>';
	echo '<input type=submit value="GO!">';
	echo '<table border="1">';
	echo '<tr>';
	echo '<th>Artist</th>';
	echo '<th>Popular</th>';
	echo '<th>Duet</th>';
	echo '<th>Rock</th>';
	echo '<th>Country</th>';
	echo '<th>50s</th>';
	echo '<th>60s</th>';
	echo '<th>70s</th>';
	echo '<th>80s</th>';
	echo '<th>90s</th>';
	echo '<th>00s</th>';
	echo '</tr>';
	$index = 1;
	$form = '';
	$artists = array();
	foreach($o as $song) {
		$artists[] = $song['a'];
	}
	$artists = array_unique($artists);
	sort($artists);
	
	foreach($artists as $a) {
		$form .= "<tr>";
		$form .= '<td>'.$a.'</td>';
		$form .= '<td align="center"><input type="checkbox" value="pop'.$index.'"/>';
		$form .= '<td align="center"><input type="checkbox" value="duet'.$index.'"/></td>';
		$form .= '<td align="center"><input type="checkbox" value="rock'.$index.'"/></td>';
		$form .= '<td align="center"><input type="checkbox" value="country'.$index.'"/></td>';
		$form .= '<td align="center"><input type="checkbox" value="50s'.$index.'"/></td>';
		$form .= '<td align="center"><input type="checkbox" value="60s'.$index.'"/></td>';
		$form .= '<td align="center"><input type="checkbox" value="70s'.$index.'"/></td>';
		$form .= '<td align="center"><input type="checkbox" value="80s'.$index.'"/></td>';
		$form .= '<td align="center"><input type="checkbox" value="90s'.$index.'"/></td>';
		$form .= '<td align="center"><input type="checkbox" value="00s'.$index.'"/></td>';
		$form .= '</tr>';
		if (!($index == $end)) {
			$index++;		
		} else {
			break;
		}
	}

	echo $form;
	echo "</table>";
	echo '<input type=submit value="GO!">';
	echo "</form>";
	echo "</body></html>";
}

