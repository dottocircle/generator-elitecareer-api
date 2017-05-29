# <%= packageName %>
This is a PHP RestFul API, created by [generator-elitecareer-api](https://github.com/mkhan004/generator-elitecareer-api). This auto generated API contains cpmplete configuration to support most common HTTP methods like `GET`, `PUT`, `POST` and `DELETE`. This API will require `PHP version 7` or higher. 

# What it supports?
1. It supports YAML configuration, to configure `requiredHeaders` and any other configuration like `db`, `baseUrl` etc.
2. It has `composer` package management system.
3. It has well configured unit test and integration test.
4. It has complete configuration for `MySQL` database connection.
5. It only supports `JSON` data for POST and Response body.

# Installation

## Download Composer
```
curl -sS https://getcomposer.org/installer | php
```

## Install Composer
```
php composer.phar install
```

## Update Composer
```
php composer.phar update
```

# Execute Test
```
php composer.phar test
```
# Setup Endpoints & Resources
### Endpoint Resource Structure
```
App::HTTP_Method('/yourEndpoint', 'resourceServingMethodName');
```
<b>Note: </b> you have to define `resourceServing` method within `controllers/dummy/dummyController.php`. You can access every single detail about any request just specifying `$appArgs` argument within `resourceServing` method. With `resourceServing` method you must have to return an Array, which will contain final response for that given `Endpoint`.
```
public function dummy($appArgs) {
  $sampleData = array();
  $sampleData['message'] = "This is sample output from 'dummy' endpoint";
  $sampleData['appArgs'] = $appArgs;
  return $sampleData;
}
```

### What `$appArgs` provides?
```
{
  "message": "This is sample output from 'dummy' endpoint",
  "appArgs": {
    "config": {
      "baseUrl": "http://localhost:8888",
      "requiredHeaders": [
        "fusion-api-key",
        "authorization",
        "content-type"
      ],
      "headerValues": {
        "fusion-api-key": [
          "fusionqateam",
          "key",
          "key"
        ],
        "content-type": [
          "application/json"
        ]
      },
      "db": {
        "bdName": {
          "host": "localhost",
          "username": "username",
          "password": "password"
        }
      }
    },
    "method": "POST",
    "path": [
      "dummy",
      "200"
    ],
    "endpoint": "dummy",
    "queryString": {
      "abc": "20"
    },
    "body": {
      "email": "test.example.com",
      "password": "someRandomPassword"
    },
    "headers": {
      "host": "localhost:8888",
      "connection": "keep-alive",
      "content-length": "67",
      "user-agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36",
      "cache-control": "no-cache",
      "origin": "chrome-extension://fhbjgbiflinjbdggehcddcbncdddomop",
      "fusion-api-key": "fusionqateam",
      "content-type": "application/json",
      "authorization": "sdf",
      "postman-token": "b5e0d896-ac6b-937a-583f-92289706a305",
      "accept": "*/*",
      "accept-encoding": "gzip, deflate, br",
      "accept-language": "en-US,en;q=0.8"
    },
    "ip": "::1",
    "requestTime": 1495999930
  }
}
```
### Endpoint Resource Example

Create Resource for GET, POST, PUT & DELETE method (within `controllers/dummy/index.php`)
```
App::get('/dummy', 'dummyGet');
App::post('/dummy', 'dummyPost');
App::put('/dummy', 'dummyPut');
App::delete('/dummy', 'dummyDelete');
```

# How to specify response code?
Just add `ErrorHandler::setResponseHeaders(yourStatusCode);` within `resourceServing` method body.

## What are currently supported Status Code?
```
  200 OK
  201 Created
  400 Bad Request
  401 Unauthorized
  404 Not Found
  405 Method Not Allowed
  500 Internal Server Error
```
