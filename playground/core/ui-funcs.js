function btnHold()
{
	$("li").bind ("taphold", function (event)
	{
		alert("HELD!");
	});
}

function inp(t)
{
	$.ajax({
	  type: "POST",
	  url: "/nextgen/core/userinput/userinput.php",
	  async: false,
	  data: "t="+t
	});
}
