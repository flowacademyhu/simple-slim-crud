<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app = new \Slim\App;

$GLOBALS['dogList'] = array(
  array(
    'id' => 'dog001', // unique ID
    'name' => 'Napolyi Masztif', // species
    'size' => 'large', // small, medium, large
    'place' => 'outdoor' // indoor, outdoor
  )
);

$app->get('/dogs', function (Request $request, Response $response, array $args) {
  return $response->withJson($GLOBALS['dogList']);
});

$app->get('/dogs/show/{id}', function (Request $request, Response $response, array $args) {
  $index = array_search($args['id'], array_column($GLOBALS['dogList'], 'id'));
  $element = $GLOBALS['dogList'][$index];
  return $response->withJson($element);
});

$app->post('/dogs', function (Request $request, Response $response, array $args) {
  $params = $request->getQueryParams();
  array_push($GLOBALS['dogList'], $params);
  return $response->withJson($GLOBALS['dogList']);
});

$app->put('/dogs/update/{id}', function (Request $request, Response $response, array $args) {
  $index = array_search($args['id'], array_column($GLOBALS['dogList'], 'id'));
  $element = $GLOBALS['dogList'][$index];
  return $response->withJson($element);
});

$app->delete('/dogs/{:id}', function (Request $request, Response $response, array $args) {
  $index = array_search($args['id'], array_column($GLOBALS['dogList'], 'id'));
  $element = $GLOBALS['dogList'][$index];
  return $response->withJson($GLOBALS['dogList']);
});

$app->run();