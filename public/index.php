<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$dsn = 'mysql:host=127.0.0.1;dbname=videoteka';
$usr = 'root';
$pwd = '';
$table = 'users';

$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);
$app = new \Slim\App;

$app->get('/resource', function (Request $request, Response $response, array $args) {
  global $pdo, $table;
  $query = $pdo->select()->from($table)->execute();
  $users = [];
  while($row = $query->fetch()) {	
    $users[] = $row;
  }
  return $response->withJson($users);
});

$app->get('/resource/{id}', function (Request $request, Response $response, array $args) {
  global $pdo, $table;
  $query = $pdo->select()->from($table)->where('id', '=', $args['id'])->execute();
  $user = $query->fetch();
  return $response->withJson($user);
});

$app->post('/resource', function (Request $request, Response $response, array $args) {
  global $pdo, $table;
  $body = $request->getParsedBody();
  $newId = $pdo->insert(array_keys($body))->into($table)->values(array_values($body))->execute();
  return $response->withJson(['created' =>  TRUE]);
});

$app->put('/resource/{id}', function (Request $request, Response $response, array $args) {
  global $pdo, $table;
  $body = $request->getParsedBody();
  $pdo->update($body)->table($table)->where('id', '=', $args['id'])->execute();
  return $response->withJson(['updated' =>  TRUE]);
});

$app->delete('/resource/{id}', function (Request $request, Response $response, array $args) {
  global $pdo, $table;
  $pdo->delete()->from($table)->where('id', '=', $args['id'])->execute();
  return $response->withJson(['deleted' =>  TRUE]);
});

$app->run();