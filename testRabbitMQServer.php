#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('login.php.inc');

function doLogin($username,$password)
{
    // lookup username in databas
    // check password
    $login = new loginDB();
    return $login->validateLogin($username,$password);
    //return false if not valid
}

function doValidate($sessionId) {

	$login = new loginDB();
	return $login->doValidate($sessionId);

}

function createLogin($newusername,$newpassword,$firstname,$lastname)
{
	$login = new loginDB();
	return $login->createLogin($newusername,$newpassword,$firstname,$lastname);

}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
	return doLogin($request['username'],$request['password']);
    	break;
    case "newlogin":
	    return createLogin($request['username'],$request['password'],$request['firstname'],$request['lastname']);
	    break;
    case "validate_session":
      return doValidate($request['sessionId']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>

