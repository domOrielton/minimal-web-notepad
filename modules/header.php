<?php

require_once 'modules/common.php';

function getFileContents($path, $client=null)
{
    $content = file_get_contents($path);
    $firstline = strtok($content, "\n"); //get the first line which is header data, not actual text/notes that has been entered
    if (checkHeader($path, $firstline)) {
        $content = stripFirstLine($content);
    } // remove the first line which is the header data so it is not shown on the page
    return ($content);
}

function checkHeader($path, $line=null, $includeJS=false)
{
    if (empty($line)) {
        if (file_exists($path)) {
            $line = fgets(fopen($path, 'r'));
        }
    } //if the line isn't passed, get the first line from the file if it exists
    $line = str_replace(array("\n", "\r"), '', $line); //remove any return characters from the string
    // Header check could be done as a single line read in a seperate function e.g. $line = fgets(fopen($path, 'r')); //https://stackoverflow.com/questions/4521936/quickest-way-to-read-first-line-from-file
    parse_str($line, $noteheader);
    $headerFound = false;
    if (isset($noteheader['noteName']) && isset($noteheader['noteHash'])) {
        if ($noteheader['noteName'] == $_GET['note'] && $noteheader['noteHash'] == base64_encode($_GET['note'])) {
            $headerFound=true;
        }
    }

    if ($headerFound) {
        $password = (isset($noteheader['password']) ? $noteheader['password'] : ''); //check if there is a password in the Header
        $pwd = (isset($noteheader['pwd']) ? $noteheader['pwd'] : ''); //check if there is a pwd in the Header
        $passwordhash = (isset($noteheader['password']) ? $noteheader['password'] : ''); //check if there is a password hash in the Header
        $allowReadOnlyView = (isset($noteheader['allowReadOnlyView']) ? $noteheader['allowReadOnlyView'] : ''); //check if view only without a password is allowed
        if (($pwd !== '' || $passwordhash !=='')) { // TODO: possibly needs sone logic for curl? && !$client)
            if ($includeJS) {
                // js functions aren't always required
              echo "<script>if (typeof showRemovePassword === 'function') {showRemovePassword();}</script>".PHP_EOL; // showRemovePassword if defined (in modal.js)
              if ($allowReadOnlyView == '1') {
                  echo "<script>if (typeof checkallowReadOnlyView === 'function') {checkallowReadOnlyView();}</script>".PHP_EOL;
              } // check allowReadOnlyView if set in the header
            }

            if (!isset($_SESSION)) {
                session_start();
            }

            if ($allowReadOnlyView == '1' and basename($_SERVER['PHP_SELF']) == 'view.php') { /* viewing the page in readonly is ok from the view.php is ok so don't prompt for password */
            } else {
                // if readonly view is not allowed and the calling page is not view.php then prompt for the password
                require_once 'modules/protect.php';
                Protect\with('modules/protect_form.php', '', $passwordhash, $allowReadOnlyView);
            }
        }
    }
    return $headerFound;
}

function setHeader($allow_password)
{
    // Add header data to the first line of the file - this will not be shown on the note
    if (!empty($_POST['notepwd'])) {
        $passwordhash =  password_hash($_POST['notepwd'], PASSWORD_DEFAULT);
    } else {
        $passwordhash = '';
    }
    if (!empty($_POST['allowReadOnlyView'])) {
     $allowReadOnlyView = $_POST['allowReadOnlyView'];
    } else {
     $allowReadOnlyView = 0;
    }
    $scope = current_url();
    $session_key = 'password_protect_'.preg_replace('/\W+/', '_', $scope);
    if (!isset($_SESSION)) {
        session_start();
    }
    // if the password and allowReadOnlyView hasn't been set from the form fields then get it from the session values
    // this solves the issue of not having the password on the page after it has been set
    if (isset($_SESSION[$session_key])) {
        if ($passwordhash == '' && $_SESSION[$session_key]) {
            $passwordhash=$_SESSION[$session_key.'hash'];
        }
        if (!empty($_POST['allowReadOnlyView']) == '' && $_SESSION[$session_key]) {
            $allowReadOnlyView=$_SESSION[$session_key.'allowReadOnlyView'];
        }
    }
    $noteHash = base64_encode($_GET['note']);  // could also use rtrim(strtr(base64_encode($_GET['note']), '+/', '-_'), '='); to remove the = chars used for padding
    $header = "[header] " . "&noteName=" . $_GET['note'] .  "&noteHash=" . $noteHash; // create the basic header content, really just an identifier
    $pwd = "";
    if ($allow_password) {
        $pwd = "&password=" . $passwordhash; //. "&pwd=" . (isset($_POST['notepwd']) ? $_POST['notepwd'] : '');
        $_SESSION[$session_key] = true;
        $_SESSION[$session_key.'hash'] = $passwordhash;
        // logic for allowing readonly view of note without password
        $pwd = $pwd . "&allowReadOnlyView=" . $allowReadOnlyView;
        $_SESSION[$session_key.'allowReadOnlyView'] = $allowReadOnlyView;
        // TODO: if the page is simple then rely on session setting
    } // create the password string for the header
    if (!empty($_POST['removePassword'])) {
        if ($_POST['removePassword'] == "1") {
            $pwd="";
            unset($_SESSION[$session_key]);
            unset($_SESSION[$session_key.'hash']);
            unset($_SESSION[$session_key.'allowReadOnlyView']);
        } //remove the password
    }
    $header = $header . $pwd . "\n"; //add the password string to the header
    // check if anything has been added to the header (password or other)
    if (trim($header) == $header) {
        // if nothing has been added then no header is needed so set it to empty
        $header = "";
    }
    return ($header);
}

function stripFirstLine($text)
{
    // from http://stackoverflow.com/questions/7740405/php-delete-the-first-line-of-a-text-and-return-the-rest
    return substr($text, strpos($text, "\n")+1); //using \n instead of PHP_EOL as better compatibility moving files between Linux and Windows
}
