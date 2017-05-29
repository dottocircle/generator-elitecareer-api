<?php

class <%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Controller {

  public function <%= endpointname %>Get($appArgs) {
    ErrorHandler::setStatusCode(200);
    $sampleData = array();
    $sampleData['message'] = "This is sample output from '<%= endpointname %>' GET endpoint";
    $sampleData['appArgs'] = $appArgs;
    return $sampleData;
  }

  public function <%= endpointname %>Post($appArgs) {
    ErrorHandler::setStatusCode(201);
    $sampleData = array();
    $sampleData['message'] = "This is sample output from '<%= endpointname %>' POST endpoint";
    $sampleData['appArgs'] = $appArgs;
    return $sampleData;
  }

  public function <%= endpointname %>Put($appArgs) {
    ErrorHandler::setStatusCode(200);
    $sampleData = array();
    $sampleData['message'] = "This is sample output from '<%= endpointname %>' PUT endpoint";
    $sampleData['appArgs'] = $appArgs;
    return $sampleData;
  }

  public function <%= endpointname %>Delete($appArgs) {
    ErrorHandler::setStatusCode(200);
    $sampleData = array();
    $sampleData['message'] = "This is sample output from '<%= endpointname %>' DELETE endpoint";
    $sampleData['appArgs'] = $appArgs;
    return $sampleData;
  }
}
