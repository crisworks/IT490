<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('testRabbitMQClient.php');

if (!isset($_POST))
{
	$msg = "NO POST MESSAGE SET, POLITELY FUCK OFF";
	echo json_encode($msg);
	exit(0);
}
$request = $_POST;
$response = "unsupported request type, politely FUCK OFF";
switch ($request["type"])
{
	case "login":
		//$response = "login, yeah we can do that";
		$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
		//$response = createClient($request);
		$response = $client->send_request($request);
		//$response = $client->publish($request);
		break; 

	case "new":
		$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
                $response = $client->send_request($request);
		$response = $client->publish($request);
		$response = "created account";	
		break;

	break;
}
echo json_encode($response);
exit(0);

?>
