<?php

namespace Seven\Providers;

use Plenty\Log\Exceptions\ReferenceTypeException;
use Plenty\Log\Services\ReferenceContainer;
use Plenty\Modules\EventProcedures\Services\Entries\ProcedureEntry;
use Plenty\Modules\EventProcedures\Services\EventProceduresService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Seven\EventProcedures\Filters;
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
        ReferenceContainer     $referenceContainer,
        ConfigRepository        $configRepository,
        Dispatcher $dispatcher,
    ): void {
        try { // Register reference types for logs.
            $referenceContainer->add(['seven' => 'seven']); // reference is optional
        } catch (ReferenceTypeException $ex) {
        }

  /*      $postCreateOrderText = $configRepository->get('Seven.events.postCreateOrderText');
        if (!empty($postCreateOrderText)) {
             // TODO add back from below
        }*/
        $eventProceduresService->registerFilter(
            'orderLocked',
            ProcedureEntry::EVENT_TYPE_ORDER,
            ['de' => 'Auftrag ist gesperrt', 'en' => 'Order is locked'],
            Filters::class . '@orderLocked'
        );
        $eventProceduresService->registerProcedure(
            'sevenOrderSms',
            ProcedureEntry::EVENT_TYPE_TICKET,
            [
                'de' => 'SMS-Versand',
                'en' => 'Send SMS',
            ],
            Procedures::class . '@sms'
        );

        $eventProceduresService->registerProcedure(
            'sevenOrderSms',
            ProcedureEntry::EVENT_TYPE_ORDER,
            [
                'de' => 'SMS-Versand',
                'en' => 'Send SMS',
            ],
            Procedures::class . '@sms'
        );

        $eventProceduresService->registerProcedure(
            'sevenOrderSms',
            ProcedureEntry::EVENT_TYPE_ORDER,
            [
                'de' => 'SMS-Versand',
                'en' => 'Send SMS',
            ],
            Procedures::class . '@sms'
        );

        $eventProceduresService->registerProcedure(
            'sevenReorderSms',
            ProcedureEntry::EVENT_TYPE_REORDER,
            [
                'de' => 'SMS-Versand',
                'en' => 'Send SMS',
            ],
            Procedures::class . '@sms'
        );
    }
}
