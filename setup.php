<?php

// this file should be deleted after setup
// it will show your notes directory path on screen
// this is very simple setup file and is not intended
// to deal with all scenarios

include('config.php');

// test the folder exists, if it doesn't then create it
if (makeDir($data_directory)) {
	echo $data_directory . ' folder is ok<br>';
	
	// make sure there is an .htaccess file there
	// if there is not then create one
	$file = $data_directory .'/.htaccess';
	if (makehtaccess($file)) { echo '.htaccess file ok<br>'; } else { echo '.htaccess file exists<br>'; } 
	
} else {
	echo $data_directory . ' folder does not exist and could not be created<br>';
}

// https://stackoverflow.com/questions/109188/how-do-i-check-if-a-directory-is-writeable-in-php
if ( ! is_writable(dirname($data_directory))) {
    echo dirname($data_directory) . ' must be writable! Please change the permissions to 0744 or 0755<br>';
} else {
    echo $data_directory . ' is writable<br>';
}
    

// https://stackoverflow.com/questions/2303372/create-a-folder-if-it-doesnt-already-exist
function makeDir($path)
{
    return is_dir($path) || mkdir($path, 0744);
}

// https://stackoverflow.com/questions/20580017/php-create-a-file-if-not-exists
function makehtaccess($file)
{
	if(!is_file($file)){
		$contents = 'Deny from all';  // deny all
		return file_put_contents($file, $contents);  // save content to the file
	}
}
?>
