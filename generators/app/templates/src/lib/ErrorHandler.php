<?php
require_once 'App.php';
require_once 'Validator.php';

class ErrorHandler {

	static function setResponseHeaders($status){
		header("Access-Control-Allow-Origin: *");
		header('Content-Type: application/json');
		header('Accept: application/json');
		ErrorHandler::setStatusCode($status);
	}

	static function setStatusCode($status){
		switch ($status) {
			case 200:
				header("HTTP/1.1 {$status} OK");
				break;
			case 201:
				header("HTTP/1.1 {$status} Created");
				break;
			case 400:
				header("HTTP/1.1 {$status} Bad Request");
				break;
			case 401:
				header("HTTP/1.1 {$status} Unauthorized");
				break;
			case 404:
				header("HTTP/1.1 {$status} Not Found");
				break;
			case 405:
				header("HTTP/1.1 {$status} Method Not Allowed");
				break;
			case 500:
				header("HTTP/1.1 {$status} Internal Server Error");
				break;
			default:
				header("HTTP/1.1 {$status} Internal Server Error");
		}
	}

	public static function errorMessage($cause, $allowed) {
		$response;
		$message = 'The request was invalid';
		switch ($cause) {
			case 'invalidEndpoint':
				ErrorHandler::setResponseHeaders(404);
				$key = App::$args['endpoint'];
				$detail = 'The specified Endpoint is invalid';
				$allowed = App::$appArgs['endpoint'];
				$response = ErrorHandler::errorStack($statusCode, $message, $key, $detail, $allowed);
				break;
			case 'invalidMethod':
				ErrorHandler::setResponseHeaders(405);
				$key = App::$args['method'];
				$detail = 'Specified method is not allowed';
				$allowed = App::$appArgs['methods'];
				$response = ErrorHandler::errorStack($statusCode, $message, $key, $detail, $allowed);
				break;
			case 'missingHeader':
				ErrorHandler::setResponseHeaders(401);
				$key = Validator::validateRequiredHeaders();
				$detail = 'The specified headers are missing';
				$response = ErrorHandler::errorStack($statusCode, $message, $key, $detail, $allowed);
				break;
			case 'invalidHeaderValue':
				ErrorHandler::setResponseHeaders(401);
				$key = Validator::validateHeaderValues();
				$detail = 'The specified header values are not supported';
				$response = ErrorHandler::errorStack($statusCode, $message, $key, $detail, $allowed);
				break;
			case 'invalidCredentials':
				ErrorHandler::setResponseHeaders(401);
				$key = App::$args['body'];
				$detail = 'Email or Password is invalid';
				$response = ErrorHandler::errorStack($statusCode, $message, $key, $detail, $allowed);
				break;
			case 'serverError':
				ErrorHandler::setResponseHeaders(500);
				$response['message'] = 'Internal Server Error';
				break;
		}

		$json_response = json_encode($response);
		return $json_response;
	}

	private static function errorStack($statusCode, $message, $key, $detail, $allowed) {
		ErrorHandler::setResponseHeaders($statusCode);
		$response['message'] = $message;
		$response['data']['key'] = $key;
		$response['data']['detail'] = $detail;
		if (!empty($allowed)) {
			$response['data']['allowed/required'] = $allowed;
		}
		return $response;
	}
}