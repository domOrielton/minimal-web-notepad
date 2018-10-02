<?php

//  configuration settings, edit settings in config.php as appropriate
// settings include the base url, the notes path and the menu items displayed
include('config.php');

// Disable caching.
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// If a note's name is not provided or contains non-alphanumeric/non-ASCII or a '-' characters.
if (!isset($_GET['note']) || !preg_match('/^([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*)$/', $_GET['note'])) {

    // Generate a name with 5 random unambiguous characters. Redirect to it.
    header("Location: $base_url/" . substr(str_shuffle('012345679abcdefghjkmnpqrstwxyz'), -5));
    die;
}

$path = $data_directory . $_GET['note'];

$include_Header = true;
$allow_password = true; // to work with files that already have a password set
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

$content = '';
if (is_file($path)) {
	$content= htmlspecialchars(getFileContents($path), ENT_QUOTES, 'UTF-8'); // requires custom function instead of just file_get_contents to handle header data in first line of file
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
    <link rel="stylesheet" href="css/simple.min.css">
</head>
<body>
    <div class="container">
		<textarea id="contentAdd" class="contentAdd" placeholder="add to the note by typing here" autofocus></textarea>
        <textarea id="content" class="content"><?php
           echo $content;
        ?></textarea>
    </div>
    <pre id="printable"></pre>
    <script src="js/script.min.js"></script>
    <script src="js/simple.min.js"></script>
    <script src="modules/js/view.min.js"></script>
  	<div class="footer">
  		<div class="navbar" id="navbar">
  			<a onclick='toggleView(this)' id='a_view' class='active'>edit</a>
  			<a onclick='location.reload();' id='a_view' class='active'>refresh</a>
  		</div>
  	</div>
    <script>toggleView('a_view');</script>
    <?php include 'modules/lastsaved.php' ?>
</body>
</html>
