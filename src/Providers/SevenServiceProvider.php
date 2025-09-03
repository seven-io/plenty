<?php

namespace Seven\Providers;

use Plenty\Log\Exceptions\ReferenceTypeException;
use Plenty\Log\Services\ReferenceContainer;
use Plenty\Modules\EventProcedures\Services\Entries\ProcedureEntry;
use Plenty\Modules\EventProcedures\Services\EventProceduresService;
use Plenty\Plugin\ServiceProvider;
use Seven\EventProcedures\OrderProcedure;

/**
 * Class SevenServiceProvider
 * @package Seven\Providers
 */
class SevenServiceProvider extends ServiceProvider {
    public function boot(
        EventProceduresService $eventProceduresService,
        ReferenceContainer     $referenceContainer,
    ): void {
        try { // Register reference types for logs.
            $referenceContainer->add(['sevenSms' => 'sevenSms']);
        } catch (ReferenceTypeException $ex) {
        }

        $eventProceduresService->registerProcedure(
            'Seven',
            ProcedureEntry::EVENT_TYPE_ORDER,
            [
                'de' => 'SMS-Versand',
                'en' => 'Send SMS',
            ],
            OrderProcedure::class . '@sms'
        );
    }
}
