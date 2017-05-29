<?php

#!/usr/bin/env php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class <%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>IntegrationTest extends TestCase {
  public $client;
  public $headers;
  public $config;

  public function setUp() {
    $this->config = Spyc::YAMLLoad('./config/prod.yaml');
    $base_uri = $this->config['baseUrl'];

    $this->client = new Client([
          'base_uri' => $base_uri
      ]);

    $this->headers = [
      'headers' => [
      'fusion-api-key' => 'yourapikey',
      'content-type' => 'application/json',
      'authorization' => 'Value 2']
    ];
  }

  public function test<%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Get() {
    $response = $this->client->get('/' . $this->config['appName'] . '/api/v1/<%= endpointname %>', $this->headers);
    $statusCode = $response->getStatusCode();
    $responseBody = json_decode($response->getBody(), true);

    $this::assertEquals(200, $statusCode);
    $this::assertEquals("This is sample output from '<%= endpointname %>' GET endpoint", $responseBody['message']);
  }

  public function test<%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Post() {
    $response = $this->client->post('/' . $this->config['appName'] . '/api/v1/<%= endpointname %>', $this->headers);
    $statusCode = $response->getStatusCode();
    $responseBody = json_decode($response->getBody(), true);

    $this::assertEquals(201, $statusCode);
    $this::assertEquals("This is sample output from '<%= endpointname %>' POST endpoint", $responseBody['message']);
  }

  public function test<%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Put() {
    $response = $this->client->put('/' . $this->config['appName'] . '/api/v1/<%= endpointname %>', $this->headers);
    $statusCode = $response->getStatusCode();
    $responseBody = json_decode($response->getBody(), true);

    $this::assertEquals(200, $statusCode);
    $this::assertEquals("This is sample output from '<%= endpointname %>' PUT endpoint", $responseBody['message']);
  }

  public function test<%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Delete() {
    $response = $this->client->delete('/' . $this->config['appName'] . '/api/v1/<%= endpointname %>', $this->headers);
    $statusCode = $response->getStatusCode();
    $responseBody = json_decode($response->getBody(), true);

    $this::assertEquals(200, $statusCode);
    $this::assertEquals("This is sample output from '<%= endpointname %>' DELETE endpoint", $responseBody['message']);
  }
}