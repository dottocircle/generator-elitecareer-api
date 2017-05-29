<?php
#!/usr/bin/env php

require_once './src/controllers/<%= endpointname %>/<%= endpointname %>Controller.php';
use PHPUnit\Framework\TestCase;

class <%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Test extends TestCase {

  public function test<%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Get() {
    $stub = $this->createMock(<%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Controller::class);
    $stub->method('<%= endpointname %>Get')
      ->willReturn('foo');

    $this::assertEquals('foo', $stub-><%= endpointname %>Get('args'));
  }

  public function test<%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Post() {
    $stub = $this->createMock(<%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Controller::class);
    $stub->method('<%= endpointname %>Post')
      ->willReturn('foo');

    $this::assertEquals('foo', $stub-><%= endpointname %>Post('args'));
  }

  public function test<%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Put() {
    $stub = $this->createMock(<%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Controller::class);
    $stub->method('<%= endpointname %>Put')
      ->willReturn('foo');

    $this::assertEquals('foo', $stub-><%= endpointname %>Put('args'));
  }

  public function test<%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Delete() {
    $stub = $this->createMock(<%= endpointname.charAt(0).toUpperCase() + endpointname.slice(1) %>Controller::class);
    $stub->method('<%= endpointname %>Delete')
      ->willReturn('foo');

    $this::assertEquals('foo', $stub-><%= endpointname %>Delete('args'));
  }
}
?>