<?php

namespace Seven\Providers;

use Plenty\Log\Exceptions\ReferenceTypeException;
use Plenty\Log\Services\ReferenceContainer;
use Plenty\Modules\EventProcedures\Services\Entries\ProcedureEntry;
use Plenty\Modules\EventProcedures\Services\EventProceduresService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Seven\EventProcedures\OrderProcedure;

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
        ConfigRepository       $configRepository,
        Dispatcher             $dispatcher,
    ): void {
        try { // Register reference types for logs.
            $referenceContainer->add(['sevenSms' => 'sevenSms']);
        } catch (ReferenceTypeException $ex) {
        }

        /*        $eventProceduresService->registerFilter(
            'orderLocked',
            ProcedureEntry::EVENT_TYPE_ORDER,
            ['de' => 'Auftrag ist gesperrt', 'en' => 'Order is locked'],
            Filters::class . '@orderLocked'
        );*/

        /*     $postCreateOrderText = $configRepository->get('Seven.events.postCreateOrderText');
             if (!empty($postCreateOrderText)) {
             }*/

        $eventProceduresService->registerProcedure(
            'Seven',
            ProcedureEntry::EVENT_TYPE_ORDER,
            [
                'de' => 'SMS-Versand',
                'en' => 'Send SMS',
            ],
            OrderProcedure::class . '@sms'
        );

        /*        $eventProceduresService->registerProcedure(
                    'sevenSmsTicket',
                    ProcedureEntry::EVENT_TYPE_TICKET,
                    [
                        'de' => 'SMS-Versand',
                        'en' => 'Send SMS',
                    ],
                    Procedures::class . '@sms'
                );

                $eventProceduresService->registerProcedure(
                    'sevenSmsReorder',
                    ProcedureEntry::EVENT_TYPE_REORDER,
                    [
                        'de' => 'SMS-Versand',
                        'en' => 'Send SMS',
                    ],
                    Procedures::class . '@sms'
                );*/
    }
}
