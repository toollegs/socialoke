#!/bin/ksh

if [[ $1 = '' ]]; then
	echo "Usage: makesite.ksh <sitename>"
	exit;
fi
rootdir=/var/www/html/beta
rm -rf $rootdir/$1
cd $rootdir
mkdir -p $1
sitedir=$rootdir/$1
cp -r c core host venue themes facebook-php-sdk $sitedir
rm -rf $sitedir/core/msgng/sms_handler.php
sed -e "s:/core:/$1/core:g" $rootdir/core/main.php > $sitedir/core/main.php
echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=http://mysocialoke.com/$1/beta/$1/core/songs/songs.php#song\">" > /var/www/html/beta/$1/pk.htm
sed -e "s:core:$1/core:g" $rootdir/core/msgng/reqconf.php > $sitedir/core/msgng/reqconf.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/userinput/userinput.php > $sitedir/core/userinput/userinput.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/fav/fav.php > $sitedir/core/fav/fav.php
sed -e "s:\$destphones=.*:\$destphones=$2;:" $rootdir/core/globals.php > $sitedir/core/globals.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/songs/songs.php > $sitedir/core/songs/songs.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/artist/artists.php > $sitedir/core/artist/artists.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/popular/popular.php > $sitedir/core/popular/popular.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/duets/duets.php > $sitedir/core/duets/duets.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/msgng/sqs/sqs.php > $sitedir/core/msgng/sqs/sqs.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/msgng/sqs/queue.php > $sitedir/core/msgng/sqs/queue.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/giglist.php > $sitedir/core/giglist.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/vote/vote.php > $sitedir/core/vote/vote.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/vote/votecast.php > $sitedir/core/vote/votecast.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/suggestsong.php > $sitedir/core/suggestsong.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/chooser.php > $sitedir/core/chooser.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/interim.php > $sitedir/core/interim.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/login.php > $sitedir/core/login.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/expired.php > $sitedir/core/expired.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/songmenu/songmenu.php > $sitedir/core/songmenu/songmenu.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/addfav/addfav.php > $sitedir/core/addfav/addfav.php
sed -e "s:/core/:/$1/core/:g" $rootdir/core/artist/asong.php > $sitedir/core/artist/asong.php
chown -R apache:apache $sitedir
chmod -R 777 $sitedir/host
chmod -R 777 $sitedir/venue
