<?php

namespace Seven\EventProcedures;

use Plenty\Modules\Account\Contact\Models\ContactOption;
use Plenty\Modules\EventProcedures\Events\EventProceduresTriggered;

class OrderProcedure extends AbstractProcedure {
    /** @noinspection PhpUnused */
    public function sms(EventProceduresTriggered $event): void {
        $order = $event->getOrder();
        $this->debug('order', $order->toArray()); // TODO remove

        $text = $this->configRepository->get('Seven.events.postCreateOrderText');
        if (empty($text)) {
            $this->debug('missing value for postCreateOrderText');
            return;
        }
        $text = $this->replacePlaceholders($order->toArray(), 'order', $text);
        $text = $this->replacePlaceholders($order->contactReceiver->toArray(), 'contactReceiver', $text);
        $this->debug('contactReceiver', $order->contactReceiver->toArray()); // TODO remove

        $to = $order->contactReceiver->privateMobile;
        if (empty($to)) {
            //$this->debug('failed to determine recipient from contactReceiver');

            $match = $order->contactReceiver->options->first(function ($obj): bool {
                //$this->debug('option', $obj->toArray());
                return $obj->subTypeId === ContactOption::SUBTYPE_MOBILE_WORK;
            });

            if ($match) {
                //$this->debug('recipient found from option', $match->toArray());
                $to = $match->value;
            }
        }
        if (empty($to)) {
            //$this->debug('missing recipient for postCreateOrderText'); // TODO
            return;
        }

        $this->dispatchSms(compact('text', 'to'));
    }
}
