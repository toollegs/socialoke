<?php

include "/var/www/html/beta/jeff-cathay_022614,1958/core/globals.php";

$url = startPage("chooser");

$b = $_GET['b'];
$q = $_GET['q'];
header("Status: 302");
if ($b == "SONG SEARCH") {
header("Location: http://s-oke.com/beta/jeff-cathay_022614,1958/core/songs/songs.php?q=".$q."&guid=".n_digit_random(6)."&s=1");
}else if ($b == "ARTIST SEARCH") {
header("Location: http://s-oke.com/beta/jeff-cathay_022614,1958/core/artist/artists.php?q=".$q."&guid=".n_digit_random(6)."&s=1");
} else {
echo "'$b'";
}
exit();
