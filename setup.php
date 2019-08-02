<?php

// this file should usually be deleted after setup
// it will show your notes directory path on screen

// all it does is check the notes folder exists and is writable
// if the folder doesn't exist it will try to create it for you
// it doesn't do anything destructive if it already exists

// if you are having trouble with permissions on the _notes folder
// (notes not saving, etc) then it might help to delete the _notes
// folder and go to this page to create the folder again

include('config.php');

// test the folder exists, if it doesn't then create it
if (makeDir($data_directory)) {
	echo $data_directory . ' folder is ok<br>';
	} else {
	echo $data_directory . ' folder does not exist and could not be created<br>';
	}

//https://stackoverflow.com/questions/109188/how-do-i-check-if-a-directory-is-writeable-in-php
if ( ! is_writable(dirname($data_directory))) {
    echo dirname($data_directory) . ' must be writable! Please change the permissions to 0744 or 0755';
	} else {
    echo $data_directory . ' is writable';
    }
    

// https://stackoverflow.com/questions/2303372/create-a-folder-if-it-doesnt-already-exist
function makeDir($path)
{
    return is_dir($path) || mkdir($path, 0744);
}

?>
