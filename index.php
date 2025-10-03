<?php
$dir = __DIR__;
$files = scandir($dir);
echo "<h1>Listing katalogu: $dir</h1><ul>";
foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    echo '<li><a href="' . htmlspecialchars($file) . '">' . htmlspecialchars($file) . "</a></li>";
}
echo "</ul>";
?>
