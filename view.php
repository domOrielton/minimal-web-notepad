<?php

// Disable caching.
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

//  configuration settings, edit settings in config.php as appropriate
// settings include the base url, the notes path and the menu items displayed
include('config.php');

$path = $data_directory . $_GET['note'];

include 'modules/header.php';

$content = '';
if (is_file($path)) {
	$content= htmlspecialchars(getFileContents($path), ENT_QUOTES, 'UTF-8'); // requires custom function instead of just file_get_contents to handle header data in first line of file
}

?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="generator" content="Minimal Web Notepad (https://github.com/domorielton/minimal-web-notepad)">
    <title><?php print $_GET['note']; ?></title>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="css/styles.min.css">
    <script src="modules/js/view.min.js"></script>
</head>
<body style="background-color:white !important; border:none !important;">
  <div id="container" class="container">
      <div id="content" class="content"><?php
         echo $content;
      ?></div>
      <pre id="printable"><?php echo $content; ?></pre>
  </div>
  <script>
	viewOnly();
	</script>
</body>
</html>
