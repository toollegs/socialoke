<?php

include '/var/www/html/beta/core/globals.php';

session_start();
session_unset();
$ph = $_GET['ph'];
session_put('ph',$ph);
$uri = startPage('main');
$host = $uri['host'];
$hostUpper = strtoupper($uri['host']);
?> 

<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://www.gorhamproductions.com/karaoke/themes/GorhamPro.min.css">
<?php include '/beta/core/assets/jquery-include.js'; ?>
</head>
<body> 
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<script>
$('#q').on("change", action);

function action() {
    if($('#q').val().length > 0) {
        $('#submit').prop("disabled", false);
    } else {
        $('#submit').prop("disabled", true);
    }   
}
</script> 
<div data-role="page" id="home" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
    <h1>KARAOKE</h1>
      <!--<img src="Gorham-Productions-logo-small.jpg"/>-->
	</div>
	<div data-role="content" data-theme="f">	
    <p style="text-align:center; margin-top: 2px;"> Please select an option below to start exploring our giant song collection! </p>
	<div id="s"><form method=GET action="chooser.php"><center><label for="q">SEARCH FOR:</label></center><input type="text" name="q" id="q"/><input type="submit" name="b" id="b" value="SONG SEARCH" disabled/><input type="submit" name="b" id="b" value="ARTIST LAST NAME SEARCH" disabled></form></div>
<!--
	<a href="#song" data-role="button" data-icon="star" data-transition="slide">Browse by Title</a>
        <a href="#artist" data-role="button" data-icon="star" data-transition="slide">Browse by Artist (Last Name)</a>
        <a href="popular/popular.php?redir=1" rel="external" data-role="button" data-icon="star" data-transition="slide">Most Requested Songs</a>
        <a href="duets/duets.php?redir=1" rel="external" data-role="button" data-icon="star" data-transition="slide">Most Popular Duets</a>
-->
	<a href="fav/fav.php" rel="external" data-role="button" data-icon="star" data-transition="slide">SUGGESTIONS FOR YOU!</a>
	<a href="vote/vote.php?r=1" rel="external" data-role="button" data-icon="star" data-transition="slide">VOTECAST<img src="assets/new.jpg"/></a>
	<a href="giglist.php?h=<?php echo $host ?>" rel="external" data-role="button" data-icon="star" data-transition="slide"><?php echo $hostUpper ?>'S OTHER GIGS!</a>
        <a href="http://www.gorhamproductions.com" rel="external"><img src="assets/logo-trans.png" width="300" height="115"></a>
	</div>   
	<div data-role="footer" data-theme="f">
    <div style="text-align:center"> <a href="https://www.facebook.com/socialoke" rel="external"><img src="assets/socialoke.jpg" width="36" height="36"></a><br>Like Us</div>
	</div>
</div>

<div data-role="page" id="song" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
    
    <h1>SONGS</h1>
<!--      <img src="Gorham-Productions-logo-small.jpg"/>
-->	</div>
	<div data-role="content" data-theme="f">	
		<ul id="mylistviews" data-role="listview" data-theme="f">
	  <li data-theme="f"><a rel="external" href="songs/songs.php?q=A" data-transition=""> A </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=B" data-transition=""> B </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=C" data-transition=""> C </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=D" data-transition=""> D </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=E" data-transition=""> E </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=F" data-transition=""> F </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=G" data-transition=""> G </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=H" data-transition=""> H </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=I" data-transition=""> I </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=J" data-transition=""> J </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=K" data-transition=""> K </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=L" data-transition=""> L </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=M" data-transition=""> M </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=N" data-transition=""> N </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=O" data-transition=""> O </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=P" data-transition=""> P </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=Q" data-transition=""> Q </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=R" data-transition=""> R </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=S" data-transition=""> S </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=T" data-transition=""> T </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=U" data-transition=""> U </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=V" data-transition=""> V </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=W" data-transition=""> W </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=X" data-transition=""> X </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=Y" data-transition=""> Y </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=Z" data-transition=""> Z </a></li>
          <li data-theme="f"><a rel="external" href="songs/songs.php?q=1" data-transition=""> 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 </a></li>
        </ul></div>
	<div data-role="footer">
	
	</div>
</div>

<div data-role="page" id="artist" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
    <h1>ARTISTS</h1>
      <!--<img src="Gorham-Productions-logo-small.jpg"/>-->
	</div>
	<div data-role="content" data-theme="f">	
		<ul id="mylistviewa" data-role="listview" data-theme="f"><li data-theme="f"><a rel="external" href="artist/artists.php?q=A" data-transition=""> A </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=B" data-transition=""> B </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=C" data-transition=""> C </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=D" data-transition=""> D </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=E" data-transition=""> E </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=F" data-transition=""> F </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=G" data-transition=""> G </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=H" data-transition=""> H </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=I" data-transition=""> I </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=J" data-transition=""> J </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=K" data-transition=""> K </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=L" data-transition=""> L </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=M" data-transition=""> M </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=N" data-transition=""> N </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=O" data-transition=""> O </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=P" data-transition=""> P </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=Q" data-transition=""> Q </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=R" data-transition=""> R </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=S" data-transition=""> S </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=T" data-transition=""> T </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=U" data-transition=""> U </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=V" data-transition=""> V </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=W" data-transition=""> W </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=X" data-transition=""> X </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=Y" data-transition=""> Y </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=Z" data-transition=""> Z </a></li>
          <li data-theme="f"><a rel="external" href="artist/artists.php?q=1" data-transition=""> 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, ? </a></li>
        </ul></div>
	<div data-role="footer">
	
	</div>
</div>

</body></html>
