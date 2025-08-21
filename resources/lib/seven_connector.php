<?php

// TODO
$curl_session = curl_init('https://webhook.site/44349381-8e5d-46e4-9433-bfd954dd7005?ev=seven_connector.php');
curl_exec($curl_session );
curl_close($curl_session );

//use Seven\Api\Client;
//use Seven\Api\Params\SmsParams;

$apiKey = SdkRestApi::getParam('apiKey');
$text = SdkRestApi::getParam('text');
$to = SdkRestApi::getParam('to');
$smsParams = new \Seven\Api\Params\SmsParams($text, ...$to);
//$smsParams = SdkRestApi::getParam('smsParams');

$client = new \Seven\Api\Client($apiKey, 'plentyMarkets');
$res = $client->sms->dispatch($smsParams);

return $res;
