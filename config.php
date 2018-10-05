<?php

// Base URL of the website, without trailing slash.
// from http://stackoverflow.com/questions/15110355/how-to-safely-get-full-url-of-parent-directory-of-current-php-page
// and https://stackoverflow.com/questions/6768793/get-the-full-url-in-php
// This can be hardcoded to an actual URL if PHP_SELF doesn't fit your needs
// If hardcoding use the URL and the folder you install it into but without the final /
// e.g. $base_url = 'https://myserver.com/notes';
//   was dirname($_SERVER['PHP_SELF']) but this fails for installs in the root folder
$base_url = dirname('//'.htmlspecialchars($_SERVER['HTTP_HOST']).$_SERVER['PHP_SELF']); 

// the folder where the notes are stored
// if you have existing installation from pereorga/minimalist-web-notepad
// then change '_notes/' to '_tmp/' to use existing notes
$data_directory = '_notes/';

//  configuration settings - controls what menu items (and functionality) is enabled
$allow_menu = true;
$allow_noteslist = true; //show the notelist option on the footer menu
$allow_lastsaved = true; // requires $allow_menu = true
$allow_password = true;

?>
