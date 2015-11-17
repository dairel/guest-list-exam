<?php
require 'vendor/autoload.php';
require 'database/ConnectionFactory.php';
require 'guests/GuestService.php';

$app = new \Slim\Slim();
// http://hostname/api/
$app->get('/', function() use ( $app ) {
    echo "Welcome to Guest REST API ";
});

  
$app->get('/guests/', function() use ( $app ) {
    $guests = GuestService::listGuests();
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($guests);
});
$app->get('/guests/:id', function($id) use ( $app ) {
    $guest = GuestService::getById($id);
    
    if($guest) {
        $app->response()->header('Content-Type', 'application/json');
        echo json_encode($guest);
    }
    else {
        $app->response()->setStatus(204);
    }
});

$app->post('/guests/', function() use ( $app ) {
    $guestJson = $app->request()->getBody();
    $newGuest = json_decode($guestJson, true);
    if($newGuest) {
        $guest = GuestService::add($newGuest);
        echo "Guest {$guest['name']} added on database";
    }
    else {
        $app->response->setStatus(400);
        echo "Invalid JSON";
    }
});
$app->put('/guests/', function() use ( $app ) {
    $guestJson = $app->request()->getBody();
    $updatedGuest = json_decode($guestJson, true);
    
    if($updatedguest && $updatedguest['id']) {
        if(GuestService::update($updatedguest)) {
          echo "Guest {$updatedGuest['name']} updated on database";  
        }
        else {
          $app->response->setStatus('404');
          echo "Guest not found";
        }
    }
    else {
        $app->response->setStatus(400);
        echo "Invalido ";
    }
});

$app->delete('/guests/:id', function($id) use ( $app ) {
    if(GuestService::delete($id)) {
      echo "deletado!";
    }
    else {
      $app->response->setStatus('404');
      echo "Guest not exist";
    }
});
$app->run();
?>