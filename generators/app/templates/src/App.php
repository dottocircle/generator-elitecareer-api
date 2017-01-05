<?php

require_once 'lib/Validator.php';
require_once 'lib/ErrorHandler.php';
require_once 'lib/Spyc.php';
error_reporting(E_ALL);
// ini_set("display_errors", 1);

class App {
  public static $args = array();
  public static $appArgs = array();
  public static $endpointsArray = array();
  public static $resourceArray = array();
  public static $currentResourceKey;
  public static $currentEndpoint = '';
  public static $methodCount = 0;

  static function collector($request){
    self::$args['config'] = Spyc::YAMLLoad('../config/prod.yaml');
    self::$args['method'] = $_SERVER['REQUEST_METHOD'];
    self::$args['path'] = explode('/', rtrim($request, '/'));
    self::$args['endpoint'] = strtolower(self::$args['path'][0]);

    if (isset($_SERVER['QUERY_STRING'])) {
      $pairs = explode('&', $_SERVER['QUERY_STRING']);
      foreach($pairs as $pair) {
        $part = explode('=', strtolower($pair));
        $queryString[$part[0]] = sizeof($part)>1 ? urldecode($part[1]) : "";
      }
      unset($queryString['request']);
    }
    self::$args['queryString'] = $queryString;
    $requestBody = json_decode(file_get_contents('php://input'), TRUE);
    $requestBody = array_change_key_case($requestBody, CASE_LOWER);
    self::$args['body'] = $requestBody;
    self::$args['headers'] = array_change_key_case(apache_request_headers(), CASE_LOWER);
    self::$args['ip'] = $_SERVER['SERVER_ADDR'];
    self::$args['requestTime'] = $_SERVER['REQUEST_TIME'];
    App::listFolderFiles('controllers');
    App::getResource(self::$args['endpoint']);
  }

  static function response() {
    $cause = Validator::validate();

    if ($cause != 1) {
      return ErrorHandler::errorMessage($cause, '');
    }

    return App::send(self::$args['endpoint']);
  }

  static function send($endpoint) {
    App::getResource($endpoint);
    $method_names = get_class_methods($endpoint.'Controller');
    ErrorHandler::setResponseHeaders(200);
    return json_encode(call_user_func(array($endpoint.'Controller', self::$appArgs['resource']), self::$args));
  }

  static function get($endpoint, $resource) {
    if (self::$currentEndpoint !== $endpoint) {
      self::$currentEndpoint = $endpoint;
      self::$methodCount = 0;
    }
    self::$resourceArray[$endpoint]['resource'][self::$methodCount] = $resource;
    self::$resourceArray[$endpoint]['method'][self::$methodCount] = 'GET';
    self::$methodCount++;
  }

  static function post($endpoint, $resource) {
    if (self::$currentEndpoint !== $endpoint) {
      self::$currentEndpoint = $endpoint;
      self::$methodCount = 0;
    }
    self::$resourceArray[$endpoint]['resource'][self::$methodCount] = $resource;
    self::$resourceArray[$endpoint]['method'][self::$methodCount] = 'POST';
    self::$methodCount++;
  }

  static function put($endpoint, $resource) {
    if (self::$currentEndpoint !== $endpoint) {
      self::$currentEndpoint = $endpoint;
      self::$methodCount = 0;
    }
    self::$resourceArray[$endpoint]['resource'][self::$methodCount] = $resource;
    self::$resourceArray[$endpoint]['method'][self::$methodCount] = 'PUT';
    self::$methodCount++;
  }

  public static function getResource($endpoint) {
    if (file_exists("controllers/{$endpoint}/index.php")) {
      require_once "controllers/{$endpoint}/index.php";
      require_once "controllers/{$endpoint}/{$endpoint}Controller.php";
      routers();
    }

    $path = self::$args['path'];
    $resourceKey;

    // initial check for direct endpoint match
    foreach (self::$resourceArray as $key => $value) {
      $fullPath = implode('/', $path);
      if ($key == '/'.$fullPath) {
        self::$currentResourceKey = $key;
        $methodIndex = array_search(self::$args['method'], self::$resourceArray[$key]['method']);
        if (!$methodIndex && $methodIndex !== 0) {
          $methodIndex = 'null';
        }
        self::$appArgs['methods'] = self::$resourceArray[self::$currentResourceKey]['method'];

        self::$appArgs['resource'] = lcfirst(self::$resourceArray[$key]['resource'][$methodIndex]);
        return;
      }
    }

    $exist = false;
    foreach (self::$resourceArray as $key => $value) {
      if (strpos($key, $path[0]) !== false) {
        if ($key[0] === '/') {
          $key = substr( $key, 1 );
        }

        $parts = explode('/', $key);
        $change = 0;
        $exist = false;
        foreach ($parts as $node => $val) {
          if (!(strpos($val, ':') !== false)) {
            if ($parts[$change] == $path[$change]) {
              $exist = true;
            } else {
              $exist = false;
            }
          }
          $change++;
        }

        $resourceKey = $key;

        if ($exist) {
          break;
        }
      }
    }

    if ($exist) {
      self::$currentResourceKey = '/'.$resourceKey;
      $methodIndex = array_search(self::$args['method'], self::$resourceArray[self::$currentResourceKey]['method']);
      if (!$methodIndex && $methodIndex !== 0) {
        $methodIndex = 'null';
      }

      self::$appArgs['methods'] = self::$resourceArray[self::$currentResourceKey]['method'];
      self::$appArgs['resource'] = lcfirst(self::$resourceArray[self::$currentResourceKey]['resource'][$methodIndex]);
      return;
    }
  }

  public static function listFolderFiles($dir){
    $ffs = scandir($dir);
    foreach($ffs as $ff){
      if($ff != '.' && $ff != '..') {
        if(is_dir($dir.'/'.$ff)) {
          $endpointsArray[] = $ff;
          App::listFolderFiles($dir.'/'.$ff);
        } else {
          $fileName = pathinfo($ff, PATHINFO_FILENAME);
          if ($fileName != 'index') {
            $classArray[] = $fileName;
            $classPathArray[] = $dir.'/'.$ff;
          }
        }
      }
    }

    self::$appArgs['endpoint'] = $endpointsArray;
  }
}