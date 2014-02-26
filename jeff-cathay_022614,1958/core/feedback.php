<?php  
include_once('/var/www/html/beta/jeff-cathay_022614,1958/core/globals.php');

$ph='none';
if (isset($_GET['ph'])) {
	$ph = $_GET['ph'];
}
//validate
$to = "beta@mysocialoke.com";
$subject = "FEEDBACK";
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no">
<!--Get jQuery & validate plug-in--> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script> 
<script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/validate/jquery.validate.js"></script>

<!--style the error message--> 
<style type="text/css"> 
.error { 
    display: block; 
    color: red; 
    font-style: italic; 
} 
#message { 
    display:none; 
    font-size:15px; 
    font-weight:bold; 
    color:#333333; 
} 
</style> 
</head>
<body>
<?php
if ($_POST) { 
//send confirmation email (or insert into database, etc...) 
?>
   <h3>Your Feedback Was Sent!</h3>
<?php
    $comments="FROM: ".$_POST['email_r']."(".$_POST['name_r'].")\r\n\r\n".$_POST['comments_r'];
    $comments = wordwrap($comments, 70, "\r\n");
    $comments=str_replace("\n.","\n..",$comments);
    $headers = '';
    $headers = 'From: beta@mysocialoke.com' . "\r\n" .
    'Reply-To: beta@mysocialoke.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    $ret = mail($to,$subject,$comments,$headers); 
} else { 
?> 
<form action="feedback.php" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
<input type="hidden" name="ph" value="<?php echo $ph; ?>"/>
     Name<br /> 
     <input name="name_r" type="text" class="required" id="name_r" /> 
     <br /> 
     <br /> 
     Email<br /> 
     <input name="email_r" type="text" class="required email" size="30" /> 
     <br /> 
     <br /> 
     Comments<br /> 
     <textarea name="comments_r" cols="25" rows="5" class="required"></textarea> 
     <br /> 
     <br /> 
     <input name="Submit" id="submit" type="submit" class="submit_go" value="Submit" /> 
      
</form>
<?php } ?>
<div id="back-button" class="centerer">
	<h3><a href="/beta/jeff-cathay_022614,1958/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
</div>
	<?php include_once('/var/www/html/beta/jeff-cathay_022614,1958/core/assets/footer.php'); ?>

</body> 
</html> 
