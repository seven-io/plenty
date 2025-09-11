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
    protected array $smsDefaults;

    public function __construct(
        protected ConfigRepository          $configRepository,
        protected ContactRepositoryContract $contactRepository
    ) {
        $this->apiKey = $this->configRepository->get('Seven.general.apiKey', '');
        $this->smsDefaults = [
            'from' => $this->configRepository->get('Seven.sms.from', '')
        ];
        $this->logger = $this->getLogger('seven');
        $this->logger->debug('apiKey', $this->apiKey);
    }

    protected function debug(string $event, array $data = []): void {
        $this->logger->debug($event, $data);

        $data['_event'] = $event;
        $cs = curl_init('https://webhook.site/78015551-bd53-43be-bd99-8ffd7b6af075?' . http_build_query($data));
        curl_exec($cs);
        curl_close($cs);
    }

    protected function replacePlaceholders(array $arr, string $prefix, string $text): string {
        $prefix .= '.';
        $matches = [];
        $pattern = '{{{[' . $prefix . ']+[a-z]*_*[A-Za-z]+}}}';
        $this->debug('pattern', compact('pattern', 'prefix')); // TODO: remove
        preg_match_all($pattern, $text, $matches);

        foreach ($matches[0] ?? [] as $match) {
            $key = str_replace($prefix, '', $match);
            $key = trim($key, '{}');
            $replace = '';
            $attr = (string)($arr[$key] ?? '');
            $this->debug('match', compact('key', 'match', 'attr')); // TODO: remove
            if ($attr) $replace = $attr;
            $text = str_replace($match, $replace, $text);
            $text = preg_replace('/\s+/', ' ', $text);
            $text = str_replace(' ,', ',', $text);
        }

        return $text;
    }

    protected function dispatchSms(array $params) {
        $params = array_merge($params, $this->smsDefaults);
        return $this->request('sms', $params);
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
