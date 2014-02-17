<?php

include '/var/www/html/beta/core/globals.php';

error_reporting(E_ERROR);

$host = $_GET['h'];
$hostUpper = strtoupper($host);
$code = '';
$day=strtolower(date('D'));
$hour=strtolower(date('H'));
if ($hour < 8) {
	$day=strtolower(date('D', strtotime(' -1 day')));
}
$now = date('mdy');
if ($hour < 8) {
	$now = date('mdy', strtotime(' -1 day'));
}

$gigsFile = file('/usr/logs/mysocialoke/giglists/'.$host);
$venues = explode(',',$gigsFile[0]);
unset($gigsFile[0]);
$tonightsVenue = getTonightsVenue();
$fullVenue = $host.'-'.trim($tonightsVenue).'_'.$now;
$code = getTonightsCode();

if (isset($_GET['sc'])) {
	$sc = $_GET['sc'];
}

function getTonightsVenue()
{
	global $day, $host, $gigsFile, $venues;

	foreach($gigsFile as $line) {
		$lineArr = explode(',',$line);
		if ($lineArr[0] == $day) {
			$venue = $lineArr[1];
			break;
		}
	}

	return $venue;
}

function getTonightsCode()
{
	global $tonightsVenue, $fullVenue;

	$globStr = "/usr/logs/mysocialoke/venuesOn/".$fullVenue."*";
	$fArr = glob($globStr);
	$fvArr=explode("/",$fArr[0]);
	$fullVenue=$fvArr[count($fvArr)-1];
	$fvArr = explode(',',$fullVenue);
	$code = $fvArr[1];
	return $code;
}

function getScheduleDiv() {
	global $host, $hostUpper, $sc;

	$ret = makeGigSelect("sun","SUNDAY",1);
	$ret .= makeGigSelect("mon","MONDAY",2);
	$ret .= makeGigSelect("tue","TUESDAY",3);
	$ret .= makeGigSelect("wed","WEDNESDAY",4);
	$ret .= makeGigSelect("thu","THURSDAY",5);
	$ret .= makeGigSelect("fri","FRIDAY",6);
	$ret .= makeGigSelect("sat","SATURDAY",7);

	$fullret .= '<div id="tab2-tab"><center><h3>SET GIGS FOR '.$hostUpper.'</h3></center><form id="gigsForm" method="POST" action="/beta/core/dboard/postgigs.php"><input type="hidden" name="h" value="'.$host.'"/>'.$ret.'<br/></br><input type=button value="GO!" name="postgigs" id="postgigs"/></form></div>';
	if (isset($sc)) {
		$fullret .= '<div id=confirm"><h3>GIGS SET!</div>';
	}
	$fullret.='<script>$( "#postgigs" ).click(function() { var serializedData = $("#gigsForm").serialize(); $.ajax({ url: "/beta/core/dboard/postgigs.php", type: "post", data: serializedData }); });</script>';
	return $fullret;
}

function makeGigSelect($sName,$dayStr,$i)
{
	global $venues, $gigsFile;
	$ret = "<select name=\"".$sName."\" id=\"d-".$sName."\">";	
	$ret .= "<option value=\"\">SELECT ".$dayStr." VENUE</option>";
	foreach($venues as $venue) {
	
		$venue=trim($venue);
		$dv = explode(',',$gigsFile[$i]);
		$thisV = trim($dv[1]);
		$selected = "";
		if ($thisV == $venue) {
			$selected = "selected";
		}
		$ret .= "<option value=\"".$venue."\" ".$selected.">".$dayStr.": ".strtoupper($venue)."</option>";
	}
	$ret .= "<option value=\"off\">OFF!</option>";
	$ret .= "</select>";
	return $ret;
}

function paintHeader()
{
	global $host;

	return '<div data-role="header" data-theme="f"><h1>DASHBOARD FOR '.strtoupper($host).'</h1></div>';
}

function paintRegCount()
{
	global $fullVenue;

	echo '<div id="regcount"><span>Registration count: '.getUserCount($fullVenue).'</span></div>';
}

function paintGigCode()
{
	global $tonightsVenue;

	$code = getTonightsCode();
	echo '<div id="gigcode"><span>Gig Code: '.$code.'('.strtoupper(trim($tonightsVenue)).')</span></div>';
}

function getStartGigText()
{
	global $tonightsVenue;

	return 'Start your gig at '.trim(strtoupper($tonightsVenue));
}

function getStopGigText()
{
	global $tonightsVenue;

	return 'Stop your gig at '.trim(strtoupper($tonightsVenue));
}

function paintStartGigButton()
{
	echo '<input type="button" id="startBtn" value="'.getStartGigText().'"/>';
}

function paintStopGigButton()
{
	echo '<input type="button" id="stopBtn" value="'.getStopGigText().'"/>';
}

function paintOffLabel()
{
	echo '<div id="offLabel" style="align:center;"><span>You are off tonight</span></div>';
}

?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Gorham Productions</title><META HTTP-EQUIV="refresh" CONTENT="30; URL=http://s-oke.com<?php echo $_SERVER["REQUEST_URI"]; ?>"><link rel="stylesheet" href="http://www.gorhamproductions.com/karaoke/themes/GorhamPro.min.css"><link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css"><script src="http://code.jquery.com/jquery-1.9.1.min.js"></script><script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script><script src="/beta/jquery-1.10.2.min.js"></script><script src="/beta/jquery.tablednd.js"></script><script src="/beta/jquery.tabify.js"></script>
<style type="text/css">
#giginfo{
	position: relative;
	width: 300px;
	top: 0px;
	left: 0;
}
</style>
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
		var params = 'from=<?php echo getHostPhone(strtolower($host)); ?>&text=<?php echo $host."+".trim($tonightsVenue)."+"."on"; ?>'; 
		$.ajax({
  			type: "GET",
			url: "/beta/core/msgng/sms_handler.php?"+params,
			data: params,
			success: function (dataCheck) {
				$('#giginfo').css("display","none");
                		$('#gigstatus').text("<?php echo strtoupper(trim($tonightsVenue)); ?> is now ON.");
				$("#queue").css("visibility", "visible");
			}
		});
		$("#giginfo").css("display","none");
		$("#gigstatus").text("Starting your gig at <?php echo strtoupper(trim($tonightsVenue)); ?>...");
	});
	$("#stopBtn").click(function(event) {
		$("#queue").css("visibility", "hidden");
		var params = 'from=<?php echo getHostPhone(strtolower($host)); ?>&text=<?php echo $host."+".trim($tonightsVenue)."+"."off"; ?>'; 
		$.ajax({
  			type: "GET",
			url: "/beta/core/msgng/sms_handler.php?"+params,
			data: params,
			success: function (dataCheck) {
				$('#giginfo').css("display","none");
                		$('#gigstatus').text("<?php echo strtoupper(trim($tonightsVenue)); ?> is now OFF.");
				$("#queuetab").css("visibility", "hidden");
			}
		});
		$("#giginfo").css("display","none");
		$("#gigstatus").text("Stopping your gig at <?php echo strtoupper(trim($tonightsVenue)); ?>...");
	});
	$('#menu').tabify();
});
</script>
</head>
<body>
<div data-role="page" id="home" data-theme="f">
	<?php echo paintHeader(); ?>
	<div data-role="content" data-theme="f">
	<div id="tab1-tab">
		<div id="giginfo">
			<div id="gigdata">
			<?php if ($code != null) { ?>
				<div id="giglive">
					<div id="gigid">
						<?php echo paintRegCount(); ?>
						<?php echo paintGigCode(); ?>
					</div>
					<?php echo paintStopGigButton(); ?>
				</div>
			<?php } else if (trim($tonightsVenue) != "off") { ?>
				<div id="gigdead">
					<?php echo paintStartGigButton(); ?>
				</div>
			<?php } else { ?>
				<div id="gigoff">
					<?php echo paintOffLabel(); ?>
				</div>
			<?php } ?>
			</div>
		</div>
		<div id="gigstatus"></div>
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
					$key = $singer.'||'.$rowArr[3];
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
			<?php if ($pn !== null && $pn !== '' && !is_numeric($pn)) { ?><td><a href="<?php echo $noteKey ?>" target="_blank">Interact</a><?php } else { ?>Coming Soon<?php } ?></td>
					<td><input type="hidden" name="row-<?php echo $i ?>" value='<?php echo $fullVenue."||".$key."||".$singer."||".$song." - ".$artist."||".$note ?>'/></td>
				</tr>
			<?php 
					$i = $i+1; 
				}
			?>
					
		</table>
		<div id="saveBtn" style="visibility: hidden;">
			<input type=submit value="GO!"/>
		</div>
	</div>
	<?php echo getScheduleDiv(); ?>
</div>
</body></html>
