<?php

include "/var/www/html/beta/core/globals.php";

$url = startPage("chooser");

$b = $_GET['b'];
$q = $_GET['q'];
header("Status: 302");
if ($b == "SONG SEARCH") {
header("Location: http://s-oke.com/beta/core/songs/songs.php?q=".$q."&guid=".n_digit_random(6));
}else if ($b == "ARTIST LAST NAME SEARCH") {
header("Location: http://s-oke.com/beta/core/artist/artists.php?q=".$q."&guid=".n_digit_random(6)."&s=1");
} else {
echo "'$b'";
}
exit();
