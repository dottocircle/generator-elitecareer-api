<?php

require_once 'App.php';


if(!empty($_REQUEST['request'])){
	App::collector($_REQUEST['request']);
	echo App::response();
}
