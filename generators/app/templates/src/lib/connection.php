<?php

class Connection{

	function __construct(){
		Connection::error();
	}

	static function dbConnection($host, $username, $password, $db_name){
		return mysqli_connect($host, $username, $password, $db_name);
	}

	static function error(){
		if(mysqli_connect_error()){
			print('Connection Error: '.mysqli_connect_error());
		}
	}

	static function close($connection_object){
		return mysqli_close($connection_object);
	}

	static function database($db, $config){
		$host = $config['db'][$db]['host'];
		$username = $config['db'][$db]['username'];
		$password = $config['db'][$db]['password'];

		return Connection::dbConnection($host, $username, $password, $db);
	}
}
