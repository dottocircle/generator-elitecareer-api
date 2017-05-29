<?php

require_once 'App.php';

function routers() {

  App::get('/<%= endpointname %>', '<%= endpointname %>Get');

  App::post('/<%= endpointname %>', '<%= endpointname %>Post');

  App::put('/<%= endpointname %>', '<%= endpointname %>Put');

  App::delete('/<%= endpointname %>', '<%= endpointname %>Delete');

}
