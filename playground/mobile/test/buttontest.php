<?php

echo "Good!";

?>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>click demo</title>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
<form id="myform"> 
<input type="submit" id="b" value="clickme!"/>
</form>
 
<script>
$( "#myform" ).submit(function() {
  alert("Yay!");
});
</script>
 
</body>
</html>
