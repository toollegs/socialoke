<?php

include '/var/www/html/beta/core/globals.php';

startPage("popular");
$dom = new DomDocument();
$urlStr='http://www.gorhamproductions.com/karaoke/popular.php';
$fstr = str_replace(' data-filter="true"','', str_replace('<a href="index.html" data-icon="arrow-l" data-rel="back" data-transition="flip">Back</a>','', file_get_contents($urlStr)));
$dom->loadHTML($fstr);
$li=$dom->getElementsByTagName('li');

for ($i = 0; $i < $li->length; $i++) {
	$liNode = $dom->getElementsByTagName('li')->item($i);
	$text = $dom->getElementsByTagName('li')->item($i)->childNodes->item(0);
	$artistPieces = explode(' - ',$text->nodeValue);
	$artistPieces[0] = str_replace('&','&amp;',$artistPieces[0]);
	$artistPieces[0] = str_replace('\'','&apos;',$artistPieces[0]);
	$artistPieces[1] = str_replace('&','&amp;',$artistPieces[1]);
	$artistPieces[1] = str_replace('\'','&apos;',$artistPieces[1]);
	$artistPieces[0] = firstlast($artistPieces[0]);
	$artistPieces[1] = firstlast($artistPieces[1]);

	$liNode->removeChild($text);
	$nv = str_replace('&','&amp;',$text->nodeValue);
	$anchor=$dom->createElement('a',$nv);
	$smsstring = urlencode(trim($artistPieces[1]).' - '.trim($artistPieces[0])); 
	$smsstring = str_replace('%26amp%3B','and',$smsstring);
	$smsstring = str_replace('%26apos%3B','',$smsstring);
	$href = "../userinput/userinput.php?t=".str_replace('+-+','+by+',$smsstring);
	$anchor->setAttribute('href',$href);
	$anchor->setAttribute('class','hover');
	$liNode->appendChild($anchor);
}

foreach ($dom->getElementsByTagName('link') as $node) {
	if (!startsWith($node->getAttribute('href'),'http:')) {
		$node->setAttribute('href','http://www.GorhamProductions.com/karaoke/'.$node->getAttribute('href'));
	}
}
#addJQuery($dom);

echo $dom->saveHTML();

?>
