<?php

$dir = 'resources/views';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$count = 0;

foreach ($files as $file) {
    if ($file->getExtension() === 'php') {
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        $new_content = str_replace("'mesage.", "'messages.", $content);
        // Also replace __() usage without surrounding single quote patterns
        $new_content = str_replace("__('mesage.", "__('messages.", $new_content);
        
        if ($content !== $new_content) {
            file_put_contents($path, $new_content);
            $count++;
            echo "Fixed: " . $file->getFilename() . "\n";
        }
    }
}

echo "Updated $count files!\n";
?>
