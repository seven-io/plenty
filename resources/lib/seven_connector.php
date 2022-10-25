<?php

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