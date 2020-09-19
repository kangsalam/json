<?php

header('Content-Type: application/json');

$url = "https://pastebin.com/raw/XsgLfLmm";
$m3ufile = file_get_contents($url);
  
$re = '/#EXTINF:(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';

preg_match_all($re, $m3ufile, $matches);

$items = array();

foreach($matches[0] as $list) {
   
   preg_match($re, $list, $matchList);
   $mediaURL = preg_replace("/[\n\r]/","",$matchList[3]);
   $mediaURL = preg_replace('/\s+/', '', $mediaURL);
   
    $newdata =  array (
		'title' => $matchList[2],
		'url' => $mediaURL
    );
	 
	$items[] = $newdata;
}

if(isset($_GET['callback']))
    echo $_GET['callback']. '(' . json_encode($items) . ')';  // jsonP callback
else
    echo json_encode($items);

?>