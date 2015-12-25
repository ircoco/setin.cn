<?php

class HttpUtil {

    public static function post($url, $data) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$tmpInfo = curl_exec($ch);
	if (curl_errno($ch)) {
	    return false;
	}
	curl_close($ch);
	return $tmpInfo;
    }

    public static function get($url) {
	$ch = curl_init();

	$curl_opt = array(CURLOPT_URL, $url,
	    CURLOPT_RETURNTRANSFER, 1,
	    CURLOPT_TIMEOUT, 1,);
	curl_setopt_array($ch, $curl_opt);
	curl_exec($ch);
	curl_close($ch);
    }

}

?>
