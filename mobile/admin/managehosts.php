<?php

include '/var/www/html/beta/core/globals.php';

function buildVenues()
{
	$f = file("/var/www/html/beta/core/knownVenues");
	$venues = array();
	$markup = '<option value="">Choose a venue</option>';
	foreach ($f as $v) {
		$vArr = explode(",",$v);
		$venue=strtolower(trim($vArr[0]));
		$venues[] = $venue;
	}
	sort($venues);
	foreach($venues as $v) {
		$markup .= '<option value="'.$v.'">'.$v.'</option>';
	}
	return $markup;
}
function buildNames()
{
	$hosts = getKnownHosts();
	ksort($hosts);
	var_dumper($hosts);
	$markup = '<option value="">Choose a host</option>';
	foreach($hosts as $h => $p) {
		$markup .= '<option value="'.$h.'-'.$p.'">'.$h.'</option>';
	}
	return $markup;
}
?>

<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<style>
#nameselect-div {
    width: 400px;
    height: 40px;
    position: relative;
}

#inputname-div,selectname-div  {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
}

#selectname-div {
    z-index: 10;
}
</style>
</head>
<body>
<form id="hostForm">
<div id="name-div">
	<div id="nameselect-div">
		<div id="inputname-div">
			<label for="name">Name(lowercase): </label><input type="text" name="name"/>
		</div>
		<div id="selectname-div" style="visibility:hidden;">
			<label for="sname">Name(lowercase): </label><select name="sname"><?php echo buildNames(); ?></select>
		</div>
	</div>
</div>
<div id="ad-div">
	<fieldset>
		<legend>Action</legend>
		<input type="radio" id="adu" name="adu1" class="adu-class" value="add" checked>Add</input>
		<input type="radio" id="adu" name="adu2" class="adu-class"  value="del">Delete</input>
		<input type="radio" id="adu" name="adu3" class="adu-class" value="upd">Update</input>
	</fieldset>
</div>
<div id="venue-div">
	<label for="venue">Venue: <select name="venue"><?php echo buildVenues(); ?></select>
</div>
<div id="days-div">
	<fieldset>
		<legend>Days Scheduled At Venue</legend>
		<input type="checkbox" name="sun"><label for="sun">Sunday</label>
		<input type="checkbox" name="mon"><label for="mon">Monday</label>
		<input type="checkbox" name="tue"><label for="tue">Tuesday</label>
		<input type="checkbox" name="wed"><label for="wed">Wednesday</label>
		<input type="checkbox" name="thu"><label for="thu">Thursday</label>
		<input type="checkbox" name="fri"><label for="fri">Friday</label>
		<input type="checkbox" name="sat"><label for="sat">Saturday</label>
	</fieldset>
</div>
<div id="phone-div">
	<label for="phone">10-digit Phone(no dashes, eg: xxxxxxxxxx):</label><input type="text" name="phone"/>
</div>
<div id="go-div">
	<input type="button" id="goBtn" value="GO!"/>
</div>
</form>
<script>
	var whichOp = 'add';
	var host = '';
	var phone = '';
	var ok = false;
	$(document).on('click', '#adu', function(e){
		$('input:radio[class=adu-class]').prop("checked",false);
		var name = $(this).prop('name');
		$("input:radio[name="+name+"]").prop("checked",true);
		var val = $(this).val();
		if (val == 'add') {
			$('#inputname-div').show();
			$('#selectname-div').hide();
			$('#venue-div').show();
			$('#days-div').show();
			$('#phone-div').show();
		} else if (val == 'del') {
			$('#inputname-div').hide();
			$('#selectname-div').show();
			$('#selectname-div').css("visibility","visible");
			$('#venue-div').hide();
			$('#days-div').hide();
			$('#phone-div').hide();
		} else if (val == 'upd') {
			$('#inputname-div').hide();
			$('#selectname-div').show();
			$('#selectname-div').css("visibility","visible");
			$('#venue-div').show();
			$('#days-div').show();
			$('#phone-div').show();
		}
		whichOp = val;
	});
	$(document).on('click', '#goBtn', function(e){
		var serializedData=$('#hostForm').serialize();
		if (whichOp == 'del') {
			var c = confirm("Are you sure you want to delete host: "+host+"?");
			ok = c;
		} else if (whichOp == 'upd') {
			var c = confirm("Are you sure you want to update host: "+host+"?");
			ok = c;
		} else if (whichOp == 'add') {
			ok = true;
		}
		if (ok == true) {
			request = $.ajax({
			        url: "/beta/admin/manageHost.php",
			        type: "post",
			        data: serializedData
			});

    // callback handler that will be called on success
			request.done(function (response, textStatus, jqXHR){
			    // log a message to the console
				console.log("Hooray, it worked!");
				console.log("Response: "+response);
//				window.location.reload(true);
			});

    // callback handler that will be called on failure
			request.fail(function (jqXHR, textStatus, errorThrown){
    // log the error to the console
				console.error("The following error occured: "+textStatus, errorThrown);
			});

    // callback handler that will be called regardless
    // if the request failed or succeeded
			request.always(function () {
			});
		}
			
	});
	$(document).on('change', 'select', function(e) {
		if ($(this).attr("name") == "sname") {
			var phoneInd = $(this).val().indexOf("-") + 1;
			phone = $(this).val().substring(phoneInd);
			host = $(this).val().substring(0,phoneInd-1);
			$("input:text[name=phone]").val(phone);
		} else if ($(this).attr("name") == "venue") {
		}
	});
</script>
</body>
</html>
