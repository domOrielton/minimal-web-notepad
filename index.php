<?php

// based on https://github.com/pereorga/minimalist-web-notepad

// configuration settings, edit settings in config.php as appropriate
// settings include the base url, the notes path and the menu items displayed
include('config.php');

// Disable caching.
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// If a note's name is not provided or contains non-alphanumeric/non-ASCII or a '-' characters.
if (!isset($_GET['note']) || !preg_match('/^([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*)$/', $_GET['note'])) {

    // Generate a name with 5 random unambiguous characters. Redirect to it.
    header("Location: $base_url/" . substr(str_shuffle('2345679abcdefghjkmnpqrstwxyz'), -5));
    die;
}

$path = $data_directory . $_GET['note'];

$include_Header = true; //required for password protected notes
include 'modules/header.php';

if (isset($_POST['text'])) {
    // Update file.
    $header = "";
    $responseText = "";
	  if ($include_Header) { if (checkHeader($path, null) || isset($_POST['notepwd'])) { $header = setHeader($allow_password);} else $header = "";}
    file_put_contents($path, $header . $_POST['text']);
    $responseText =  "saved"; //for lastsaved logic

    // the following 3 lines can be commented out if you don't want to check write permissions
    $filecheck = file_exists($path);
    if ($filecheck) $responseText =  "saved"; //for lastsaved logic
    if (!is_writable($path)) $responseText = 'error';

    // If provided input is empty, delete file.
    if (!strlen($_POST['text'])) {
        unlink($path);
        $responseText = "deleted";
    }
    echo $responseText;
    die();

}

// Output raw file if client is curl. No current handling of password protected notes
if (strpos($_SERVER['HTTP_USER_AGENT'], 'curl') === 0) {
    if (is_file($path)) {
      if ($include_Header)  {
        print getFileContents($path, 'curl');
      }
      else {
        file_get_contents($path, 'curl');
      }
    }
    die();
}

$content = '';
if (is_file($path)) {
  if ($include_Header)  {
    // requires custom function instead of just file_get_contents to handle header data in first line of file
	  $content= htmlspecialchars(getFileContents($path), ENT_QUOTES, 'UTF-8');
  }
  else {
      file_get_contents($path, ENT_QUOTES, 'UTF-8');
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="generator" content="Minimal Web Notepad (https://github.com/domorielton/minimal-web-notepad)">
  <title><?php print $_GET['note']; ?></title>
  <link rel="shortcut icon" href="favicon.ico">
  <link rel="stylesheet" href="css/styles.min.css">
</head>
<body>
  <div id="container" class="container">
      <textarea id="content" class="content"><?php
         echo $content;
      ?></textarea>
  </div>
  <pre id="printable"></pre>
	<script src="js/script.min.js"></script>
  <?php
  if ($allow_menu) include 'modules/menu.php';
  if ($allow_lastsaved) include 'modules/lastsaved.php';
  // add this last to make sure modal handling is loaded
  if ($allow_password) {
    include 'modules/password.php';
    echo '<script src="modules/js/modal.min.js"></script>'.PHP_EOL;
    echo "<script src='modules/js/password.min.js'></script>".PHP_EOL;
  }
	if ($include_Header) { checkHeader($path, null, true); } //check if the removePassword be shown ?>
</body>
</html>
