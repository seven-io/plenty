<?php

namespace Seven\EventProcedures;

use Plenty\Modules\Account\Contact\Models\ContactOption;
use Plenty\Modules\EventProcedures\Events\EventProceduresTriggered;

class OrderProcedure extends AbstractProcedure {
    /** @noinspection PhpUnused */
    public function sms(EventProceduresTriggered $event): void {
        $order = $event->getOrder();
        $this->debug('order', $order->toArray());

        $text = $this->configRepository->get('Seven.events.postCreateOrderText');
        if (empty($text)) {
            $this->debug('missing value for postCreateOrderText');
            return;
        }

        $to = $order->contactReceiver->privateMobile;
        if (empty($to)) {
            $this->debug('failed to determine recipient from contactReceiver');

            $match = $order->contactReceiver->options->first(function ($obj) {
                $this->debug('option', $obj->toArray());
                return $obj->subTypeId === ContactOption::SUBTYPE_MOBILE_WORK;
            });

            if ($match) {
                $this->debug('recipient found from option', $match->toArray());
                $to = $match->value;
            }
        }
        if (empty($to)) {
            $this->debug('missing recipient for postCreateOrderText');
            return;
        }

        $this->dispatchSms(compact('text', 'to'));
    }
}
