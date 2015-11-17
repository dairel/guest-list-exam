<?php
require 'vendor/autoload.php';
require 'database/ConnectionFactory.php';
require 'tasks/TaskService.php';


$app = new \Slim\Slim();
// http://hostname/api/
$app->get('/', function() use ( $app ) {
    echo "Welcome to Guest List REST API";
});


$app->get('/guests/', function() use ( $app ) {
    $guests = TaskService::listguests();
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($guests);
});


$app->get('/guests/:id', function($id) use ( $app ) {
    $guests = TaskService::getById($id);
    
    if($guests) {
        $app->response()->header('Content-Type', 'application/json');
        echo json_encode($guests);
    }
    else {
        $app->response()->setStatus(204);
    }
});


$app->post('/guests/', function() use ( $app ) {
    $guestsJson = $app->request()->getBody();
    $newguests = json_decode($guestsJson, true);
    if($newguests) {
        $guests = TaskService::add($newguests);
        echo "Task {$guests['name']} added";
    }
    else {
        $app->response->setStatus(400);
        echo "Malformat JSON";
    }
});

$app->put('/guests/', function() use ( $app ) {
    $guestsJson = $app->request()->getBody();
    $updatedguests = json_decode($guestsJson, true);
    
    if($updatedguests && $updatedguests['id']) {
        if(TaskService::update($updatedguests)) {
          echo "guests {$updatedguests['name']} updated";  
        }
        else {
          $app->response->setStatus('404');
          echo "People not found";
        }
    }
    else {
        $app->response->setStatus(400);
        echo "Malformat JSON";
    }
});

$app->run();
?>