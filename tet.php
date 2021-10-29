
<?php

$files= array();
$dir = dir('uploads');
while ($file = $dir->read()) {
    if ($file != '.' && $file != '..') {
        $files[] = $file;
    }
}

var_dump($files);
?>