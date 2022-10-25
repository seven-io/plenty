<?php

namespace Seven\EventProcedures;

use Plenty\Modules\EventProcedures\Events\EventProceduresTriggered;
use Plenty\Modules\Order\Contracts\OrderRepositoryContract;
use Plenty\Modules\Plugin\Libs\Contracts\LibraryCallContract;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;

class Procedures {
    use Loggable;

    public function sms(
        ConfigRepository         $config,
        EventProceduresTriggered $event,
        LibraryCallContract      $libraryCallContract
    ): void {
        $apiKey = $config->get('Seven.apiKey');
        //$client = new Client($apiKey);
        $text = 'HI2U';
        $to = ['491716992343', '4917661254799'];
        //$smsParams = new SmsParams($text, ...$to);
        $res = $libraryCallContract->call('Seven::seven_connector', compact('apiKey', 'text', 'to'));

        $this
            ->getLogger('MyController_doSomething')
            ->setReferenceType('smsReference') // optional
            ->setReferenceValue($res) // optional
            ->debug('Seven::sms', [$res]) // additional information is optional
        ;

        $order = $event->getOrder();
        $orderRepository = pluginApp(OrderRepositoryContract::class);
        //$orderRepository->updateOrder(['statusId' => 3], $order->id);
    }
}
