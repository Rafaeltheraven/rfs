<?php

function getFiles($dir, &$results = array()) {
	$fileSystemIterator = new fileSystemIterator($dir);
	
	foreach ($fileSystemIterator as $fileInfo) {
		if ($fileInfo -> isDir()) {
			getFiles($fileInfo -> getPathname(), $results);
		} else {
			$results[] = array(
				'filename' => $fileInfo -> getPathname(),
				'mtime' => $fileInfo -> getMTime(),
				'ctime' => $fileInfo -> getCTime(),
			);
		}
	}
	return $results;
}

?>
