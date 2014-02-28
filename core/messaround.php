<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><?php echo file_get_contents('http://s-oke.com/beta/core/assets/jquery-include.php'); ?>
<script type="text/javascript">
	function getSongsForArtist(a) {
		var url = "http://s-oke.com/beta/core/artist/artists.php?q="+a;
		alert(url);
		$.ajax({
			type: "GET",
			url: url,
			success: function(resp) {
				alert("resp: "+resp);
				$('#result').val(resp);
			}

		});
	}
</script>
</head>
<body>
<input type="text" id="n"></input>
<input type="button" value="Show" onclick="javascript:getSongsForArtist($('#n').val());"></input>
<textarea id="result"></textarea>
</body>
</html>
