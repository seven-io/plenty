<?php

namespace Seven\EventProcedures;

use Plenty\Modules\EventProcedures\Events\EventProceduresTriggered;
use Plenty\Modules\Plugin\Libs\Contracts\LibraryCallContract;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;

class Procedures {
    use Loggable;

    public function __construct(
        protected ConfigRepository    $config,
        protected LibraryCallContract $libraryCallContract
    ) {
    }

    protected function debug(): void {
        $curl_session = curl_init('https://webhook.site/44349381-8e5d-46e4-9433-bfd954dd7005?ev=seven_connector.php');
        curl_exec($curl_session);
        curl_close($curl_session);
    }

    public function sms(EventProceduresTriggered $event): void {
        $this->debug();

        $this
            ->getLogger('seven')
            ->debug('Seven::sms') // additional information is optional
        ;

        $apiKey = $this->config->get('Seven.general.apiKey'); // $config->get('Seven.apiKey');
        $this
            ->getLogger('seven')
            ->debug('Seven::apiKey', $apiKey) // additional information is optional
        ;
        //$client = new Client($apiKey);
        $text = 'HI2U';
        $to = ['491716992343', '4917661254799'];
        //$smsParams = new SmsParams($text, ...$to);
        $smsParams = compact('text', 'to');
        $ch = curl_init('https://gateway.seven.io/api/sms');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($smsParams));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-type: application/json',
            'SentWith: plentyOne',
            'X-Api-Key: ' . $apiKey,
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        //var_dump($res);

        //$res = $this->libraryCallContract->call('Seven::seven_connector', $smsParams);

        $this
            ->getLogger('seven')
            ->setReferenceType('smsReference') // optional
            ->setReferenceValue($res) // optional
            ->debug('Seven::sms', $res) // additional information is optional
        ;
    }
}
