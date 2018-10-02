<?php
if (!file_exists('_notes/')) {
    // create folder with read/write permission
    mkdir('_notes', 0755, false);
    // add .htaccess file
    $f = fopen("_notes/.htaccess", "a+");
    fwrite($f, "Deny from all");
    fclose($f);
}
?>
