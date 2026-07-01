<?php
$theme_dir = 'd:/xampp82/htdocs/astcc/wp-content/themes/2026';

$exclude_dirs = [
    $theme_dir . '/page',
    $theme_dir . '/template',
    $theme_dir . '/class/qrcode'
];

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($theme_dir));
$php_files = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

$rename_map = [];
$files_to_rename = [];

foreach ($php_files as $file) {
    $path = str_replace('\\', '/', $file[0]);
    
    if (strpos($path, 'refactor_filenames.php') !== false) {
        continue;
    }
    
    $skip = false;
    foreach ($exclude_dirs as $ex) {
        if (strpos($path, $ex) === 0) {
            $skip = true;
            break;
        }
    }
    
    if ($skip) continue;

    $basename = basename($path);
    if (strpos($basename, '_') !== false) {
        $new_basename = str_replace('_', '-', $basename);
        $rename_map[$basename] = $new_basename;
        $files_to_rename[$path] = dirname($path) . '/' . $new_basename;
    }
}

foreach ($files_to_rename as $old_path => $new_path) {
    echo "Renaming: " . basename($old_path) . " -> " . basename($new_path) . "\n";
    rename($old_path, $new_path);
}

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($theme_dir));
$all_php_files = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($all_php_files as $file) {
    $path = str_replace('\\', '/', $file[0]);
    if (strpos($path, 'refactor_filenames.php') !== false) continue;
    
    $content = file_get_contents($path);
    $new_content = $content;
    
    foreach ($rename_map as $old => $new) {
        $new_content = str_replace("'" . $old . "'", "'" . $new . "'", $new_content);
        $new_content = str_replace('"' . $old . '"', '"' . $new . '"', $new_content);
        $new_content = str_replace("/" . $old, "/" . $new, $new_content);
        $new_content = str_replace("\\" . $old, "\\" . $new, $new_content);
    }
    
    if ($content !== $new_content) {
        echo "Updating references in: " . basename($path) . "\n";
        file_put_contents($path, $new_content);
    }
}

echo "Refactoring completed successfully.\n";
