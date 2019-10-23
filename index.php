<?php

header("Content-Type: application/rss+xml; charset=ISO-8859-1");

$configs = include('config.php');

include('utils.php');

$rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
$rssfeed .= '<rss version="2.0">';
$rssfeed .= '<channel>';
$rssfeed .= '<title>' . $configs['title'] . '</title>';
$rssfeed .= '<link>' . $configs['url'] . '</link>';
$rssfeed .= '<description>' . $configs['description'] . '</description>';
$rssfeed .= '<language>en-us</language>';

$root = $configs['root'];

$entries = getFiles($root);

usort($entries, function($a, $b) {
	return $b["mtime"] <=> $a["mtime"];
});

$entries = array_slice($entries, 0, 10);

foreach($entries as $entry) {
	$path = $entry['filename'];
	$mtime = $entry['mtime'];
	$ctime = $entry['ctime'];
	$rssfeed .= "<item>";
	if ($mtime == $ctime) {
		$rssfeed .= "<title> File " . $path . " created or permissions modified </title>";
	} else {
		$rssfeed .= "<title> File " . $path . " was modified </title>";
	}
	$rssfeed .= "<description> For security reasons, no more info is shown. Check out " . $path . " yourself.</description>";
	$rssfeed .= "<link>" .  $configs['url'] . "</link>";
	$rssfeed .= "<pubDate>" . date("r", $mtime) . "</pubDate>";
	$rssfeed .= "</item>";
}

$rssfeed .= "</channel>";
$rssfeed .= "</rss>";

echo $rssfeed;

?>
