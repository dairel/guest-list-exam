<?php
require 'vendor/autoload.php';
require 'database/ConnectionFactory.php';
require 'Guest/GuestService.php';

$app = new \Slim\Slim();
$app->get('/guest/', function() use ($app){
    $db = ConnectionFactory::getDB();
    
    $guests = array();
    foreach($db->guests() as $guests){
        $guests[] = array(
            'id' => $guest["id"],
            'name' => $guest['name'], 
            'email' => $guest['email']
        );
    }
    
    $app->response()->header('Content-Type','application/json');
    echo json_encode($guests);
});

$app->post('/guest', function () use ( $app ) {
	$db = ConnectionFactory::getDB();
	
	$guestToAdd = json_decode($app->request->getBody(), true);
	$guest = $db->guests->insert($guestToAdd);
	
	$app->response->header('Content-Type', 'application/json');
	echo json_encode($guest);
});
$app->delete('/guest/:name', function($name) use ( $app ) { 
	$db = ConnectionFactory::getDB();
	$response = "";
	
	$guest = $db->guests()->where('name', $name);
	
	if($guest->fetch()) {
		$result = $guest->delete();
		$response = array(
			'status' => 'true',
			'message' => 'People Deleted'
		);
	}
	else {
		$response = array(
			'status' => 'false',
			'message' => 'people not exists'
		);
		$app->response->setStatus(404);
	}
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);
});
?>