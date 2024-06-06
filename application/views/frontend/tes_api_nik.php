<?php

$curl = curl_init();
//$nik = '3201293010880006';
curl_setopt_array($curl, [
	CURLOPT_URL => "https://indonesian-identification-card-ktp.p.rapidapi.com/api/v3/check?nik=" . $nik,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: indonesian-identification-card-ktp.p.rapidapi.com",
		"X-RapidAPI-Key: 95e4ac14abmsh54ac15839e0ea23p1b40e0jsn189f29020069"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}
