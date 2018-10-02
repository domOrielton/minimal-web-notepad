<?php
# https://gist.github.com/4692807
namespace Protect;
# Will protect a page with a simple password. The user will only need
# to input the password once. After that their session will be enough
# to get them in. The optional scope allows access on one page to
# grant access on another page. If not specified then it only grants
# access to the current page.
function with($form, $password, $passwordhash=null,$allowReadOnlyView=null, $scope=null) {
	//writeToLog('Starting with.');
  if( !$scope ) $scope = current_url();
  $session_key = 'password_protect_'.preg_replace('/\W+/', '_', $scope);
  if (!isset($_SESSION)) session_start();
  # Check the POST for access
  if (!empty($_POST['password']))
  {
	$isPasswordCorrect = false;
	// first check against the password hash
	$isPasswordCorrect = password_verify($_POST['password'], $passwordhash);

	// if there wasn't a password hash passed then just check plain text
	if( $_POST['password'] == $password && empty($passwordhash) ) {  $isPasswordCorrect=true;}

	if ($isPasswordCorrect) {
    // set session variables with required values
  	$_SESSION[$session_key] = true;
  	if (!empty($passwordhash)) {
  			$_SESSION[$session_key.'hash'] = $passwordhash;
  			}
    if (!empty($allowReadOnlyView)) {
        $_SESSION[$session_key.'allowReadOnlyView'] = 1;
    }
  	redirect(current_url());
	}
  }
  # If user has access then simply return so original page can render.
  if(isset($_SESSION[$session_key])) {if( $_SESSION[$session_key] ) return;}
  require $form;

  exit;
}

require_once 'modules/common.php';
