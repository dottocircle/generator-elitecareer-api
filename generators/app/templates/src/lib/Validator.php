<?php
require_once 'App.php';

class Validator {

	static function validate() {
		$missingHeaders = Validator::validateRequiredHeaders();
		if (sizeof($missingHeaders) > 0) {
			return 'missingHeader';
		}

		if (!Validator::validateEndpoints()) {
			return 'invalidEndpoint';
		}

		if (!Validator::validateMethods()) {
			return 'invalidMethod';
		}

		$headerValues = Validator::validateHeaderValues();
		if (sizeof($headerValues) > 0) {
			return 'invalidHeaderValue';
		}

		return true;
	}

	static function validateHeaderValues() {
		$values = array();
		foreach (array_keys(App::$args['headers']) as $header) {
			if (in_array($header, App::$args['config']['requiredHeaders'])) {
				if (in_array($header, array_keys(App::$args['config']['headerValues']))) {
					$value = strtolower(App::$args['headers'][$header]);
					if (!in_array($value, App::$args['config']['headerValues'][$header])) {
						$values[$header] = App::$args['headers'][$header];
					}
				}
			}
		}

		return $values;
	}

	static function validateRequiredHeaders() {
		$headers = array();
		foreach (App::$args['config']['requiredHeaders'] as $header) {
			$valid = array_key_exists($header, App::$args['headers']);
			if (!$valid) {
				$headers[] = $header;
			}
		}
		return $headers;
	}

	static function validateMethods() {
		return in_array(strtoupper(App::$args['method']), App::$appArgs['methods']);
	}

	static function validateEndpoints() {
		return in_array(strtolower(App::$args['endpoint']), App::$appArgs['endpoint']);
	}
}

