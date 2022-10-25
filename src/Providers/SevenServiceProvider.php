<?php

namespace Seven\Providers;

use Plenty\Log\Exceptions\ReferenceTypeException;
use Plenty\Log\Services\ReferenceContainer;
use Plenty\Modules\EventProcedures\Services\Entries\ProcedureEntry;
use Plenty\Modules\EventProcedures\Services\EventProceduresService;
use Plenty\Plugin\ServiceProvider;
use Seven\EventProcedures\Procedures;

/**
 * Class SevenServiceProvider
 * @package Seven\Providers
 */
class SevenServiceProvider extends ServiceProvider {
    /** Register the route service provider */
    public function register() {
        $this->getApplication()->register(SevenRouteServiceProvider::class);
    }

    public function boot(
        EventProceduresService $eventProceduresService,
        ReferenceContainer     $referenceContainer
    ): void {
        // Register reference types for logs.
        try {
            $referenceContainer->add(['smsReference' => 'smsReference']); // reference is optional
        } catch (ReferenceTypeException $ex) {
        }

        $eventProceduresService->registerProcedure(
            'sms',
            ProcedureEntry::EVENT_TYPE_ORDER,
            [
                'de' => 'SMS-Versand',
                'en' => 'Send SMS',
            ],
            Procedures::class . '@sms'
        );
    }
}