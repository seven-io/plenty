<?php

namespace Seven\EventProcedures;

use Plenty\Modules\EventProcedures\Events\EventProceduresTriggered;

class Filters {
    /** @noinspection PhpUnused */
    public function orderLocked(EventProceduresTriggered $event): bool {
        return $event->getOrder()->lockStatus != 'unlocked';
    }
}
