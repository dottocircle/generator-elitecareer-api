<?php

class <%= endpointname %>Controller {

	public static function <%= endpointname %>() {
    $sampleData = array();
    $sampleData['messase'] = "This is sample output from <%= endpointname %>";
		return $sampleData;
	}
}
