<?php

include '/var/www/html/beta/core/dboard/setgigs.php';

error_reporting(E_ERROR);

$host = $_GET['h'];
$hostUpper = strtoupper($host);
$code = '';
$host = $_GET['h'];
$day=strtolower(date('D'));
$hour=strtolower(date('H'));
if ($hour < 8) {
	$day=strtolower(date('D', strtotime(' -1 day')));
}
$f = file('/usr/logs/mysocialoke/giglists/'.$host);
unset($f[0]);
foreach($f as $line) {
	$lineArr = explode(',',$line);
	if ($lineArr[0] == $day) {
		$venue = $lineArr[1];
		break;
	}
}
$now = date('mdy');
if ($hour < 8) {
	$now = date('mdy', strtotime(' -1 day'));
}
$fullVenue = $host.'-'.trim($venue).'_'.$now;
$fArr = glob('/usr/logs/mysocialoke/venuesOn/'.$fullVenue.",*");
$fvArr=explode("/",$fArr[0]);			
$fullVenue=$fvArr[count($fvArr)-1];
$fvArr = explode(',',$fullVenue);
$code = $fvArr[1];
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><META HTTP-EQUIV="refresh" CONTENT="30; URL=http://s-oke.com<?php echo $_SERVER["REQUEST_URI"]; ?>"><link rel="stylesheet" href="http://www.gorhamproductions.com/karaoke/themes/GorhamPro.min.css"><link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css"><script src="http://code.jquery.com/jquery-1.9.1.min.js"></script><script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script><script src="/beta/jquery-1.10.2.min.js"></script><script src="/beta/jquery.tablednd.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#queueTbl").tableDnD({
		onDrop: function(table, row) {
			$("#saveBtn").css("visibility", "visible");
    		},
    		dragHandle: ".dragHandle"
	});	
	$('#queueTbl tr input').click(function (event) {
		$.ajax({
  			type: "POST",
			url: "/beta/core/host-dashboard/remove_singer.php",
			data: "id="+$(this).attr('id')
		}); 
		$(this).closest("tr").remove();
	});
	$("#saveBtn").click(function(event) {
		var params = $("#queueTbl :input").serialize();
		$.ajax({
  			type: "POST",
			url: "/beta/core/host-dashboard/resavelist.php",
			data: params
		}); 
		$("#saveBtn").css("visibility", "hidden");
	});
	$("#startBtn").click(function(event) {
		var params = 'from=<?php echo getHostPhone(strtolower($host)); ?>&text=<?php echo $host."+".trim($venue)."+"."on"; ?>'; 
		$.ajax({
  			type: "GET",
			url: "/beta/core/msgng/sms_handler.php?"+params,
			data: params
		}); 
		$("#giginfo").css("visibility", "hidden");
		$("#startGigText").css("visibility", "visible");
	});
	$("#stopBtn").click(function(event) {
		var params = 'from=<?php echo getHostPhone(strtolower($host)); ?>&text=<?php echo $host."+".trim($venue)."+"."off"; ?>'; 
		$.ajax({
  			type: "GET",
			url: "/beta/core/msgng/sms_handler.php?"+params,
			data: params
		}); 
		$("#giginfo").css("visibility", "hidden");
		$("#stopGigText").css("visibility", "visible");
	});
});
</script>
</head>
<body> 
<div id="fb-root"></div>
<div data-role="page" id="home" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1>DASHBOARD FOR <?php echo strtoupper($hostUpper); ?></h1>
	</div>
	<div data-role="content" data-theme="f">
	<div id="hd_info">
		<div id="queuetab">
		<div id="giginfo"><?php if ($code != null) { ?><div id="gigdata">Registration count: <?php echo getUserCount($fullVenue); ?><br/>Gig Code: <?php echo $code; ?> (<?php echo strtoupper(trim($venue)); ?>)</div><?php } else if (trim($venue) != "off") { ?><input type="button" id="startBtn" value="Start your gig at <?php echo trim(strtoupper($venue)); ?>"/><?php } else { ?><center>You are off tonight</center><?php } ?></div>
		<div id="startGigText" style="visibility:hidden;">Starting your gig at <?php echo strtoupper($venue); ?>...</div>
		<div id="stopGigText" style="visibility:hidden;">Stopping your gig at <?php echo strtoupper($venue); ?>...</div>
		<div id="queue" <?php if (!isset($code) || $code == '') { ?>style="visibility:hidden;"<?php } ?>>
		<table id="queueTbl" data-role="table" data-mode="column-toggle">
			<thead>
			<tr class="nodrag nodrop" style="font-size: 14px;">
			<th colspan=5>Tonight's Current Queue</th>
			</tr>	
			<tr class="nodrag nodrop" style="font-size: 14px;">
			<th style="text-align:left;">Singer</th>
			<th style="text-align:left;">Song</th>
			<th style="text-align:left;">Signed up</th>
			<th style="text-align:left;">Note</th>
			<th style="text-align:left;">Votes</th>
			<th style="text-align:left;">Interact</th>
			</tr>
			</thead>
			<?php 
				$fn = '/usr/logs/mysocialoke/venuesOn/'.$fullVenue;
				$f = file($fn);
				$votes = array();
				$vfn='/usr/logs/mysocialoke/votes/'.$fullVenue.'.log';
				$vf = file($vfn);
				$totVotes = array();
				foreach($vf as $line) {
					$rowArr=explode('||',$line);
					$key = str_replace(' ','',$rowArr[1].'||'.$rowArr[2].'||'.$rowArr[3]);
					$key = str_replace('.','',$key);
					if (trim($rowArr[4]) == 'on') {
						$votes[$key] = 1;
					} else if (trim($rowArr[4]) == 'off') {
						$votes[$key] = 0;
					}
				}
				foreach($votes as $key => $val) {
					$sKeyArr = explode('||',$key);
					$sKey = $sKeyArr[1].'||'.$sKeyArr[2];
					$votes[$sKey] = $votes[$sKey] + $votes[$key];
				}
				$i = 1; 
				foreach($f as $row) { 
					$rowArr=explode('||',$row);
					$st=$rowArr[0];
					$now = strtotime(getDateForLog());
					$signuptime = strtotime($st);
					$waittime = round(($now - $signuptime)/60);
					if ($waittime == 0) {
						$waittime = "< 1 min ago";
					} else {
						$waittime .= ' mins ago';
					}
					$pn=$rowArr[1];
					$singer=$rowArr[2];
					$saArr = explode(' by ',$rowArr[3]);
					$song = $saArr[0];
					$artist = $saArr[1];
					$note = trim($rowArr[4]);
					$noteKey = trim($rowArr[5]);
					$key = $singer.'||'.$rowArr[4];
					$key = str_replace(' ','',$key);
					$key = str_replace('.','',$key);
					$key = str_replace('[','(',$key);
					$key = str_replace(']',')',$key);
					$theseVotes = $votes[$key];
			?>
			<tr id="<?php echo $i ?>" style='font-size: 12px;'>
			<td><?php echo $singer ?></td>
			<td><?php echo firstlast($song).' by '.firstlast($artist) ?></td>
			<td><?php echo $waittime ?></td>
			<td><?php echo $note ?></td>
			<td><?php echo $theseVotes; ?></td>
			<?php if ($pn !== null && $pn !== '' && !is_numeric($pn)) { ?><td><?php if (isset($note) && strlen($note) > 0) { ?><a href="<?php echo $noteKey ?>" target="_blank">Interact</a><?php } else { ?>Coming Soon<?php } ?></td><?php } else { ?><td>Not available</td><?php } ?>
			<!-- <td><input type="button" id="removeBtn-<?php echo $fullVenue."-".$i ?>" value="REMOVE" data-inline="true" data-mini="true"/></td> -->
			<td><input type="hidden" name="row-<?php echo $i ?>" value='<?php echo $fullVenue."||".$key."||".$singer."||".$song." - ".$artist."||".$note ?>'/></td><a href</tr>
			<?php 
					$i = $i+1; 
				}
			?>
				
		</table>
		</div>
		<div id="saveBtn" style="visibility: hidden;">
			<input type=submit value="GO!"/>
		</div>
		<?php if (isset($code) && $code != '') { ?>
		<div id="stopBtn"><input type="button" value="Stop your gig at <?php echo trim(strtoupper($venue)); ?>"/></div>
		<?php } ?>
	</div>
	<?php echo getOutput(); ?>
	</div>
</div>
	
</body></html>
