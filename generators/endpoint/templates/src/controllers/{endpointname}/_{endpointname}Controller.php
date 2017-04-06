<?php

class <%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Controller {

  public static function <%= endpointname %>() {
    ErrorHandler::setStatusCode(200);
    $sampleData = array();
    $sampleData['messase'] = "This is sample output from '<%= endpointname %>' endpoint";
    return $sampleData;
  }
}
