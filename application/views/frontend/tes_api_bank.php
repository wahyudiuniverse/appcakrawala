<?php

$curl = curl_init();
//$nik = '3201293010880006';
curl_setopt_array($curl, [
	// CURLOPT_URL => "https://api-rekening.lfourr.com/getBankAccount?bankCode=014&accountNumber=1370176121",
	CURLOPT_URL => "https://api-rekening.lfourr.com/getBankAccount?bankCode=426&accountNumber=021000020081642",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}
