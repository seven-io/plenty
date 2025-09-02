<?php

namespace Seven\Controllers;

use Plenty\Log\Contracts\LoggerContract;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Log\Loggable;

class WebhookController extends Controller
{
    use Loggable;

    protected LoggerContract $logger;

    public function __construct() {
        parent::__construct();

        $this->logger = $this->getLogger('seven');
    }

    public function handle(array $payload): bool
    {
        ['body' => $body, 'id' => $id, 'type' => $type] = $payload;

        $this->logger->debug('webhook', $payload);

        switch ($type) {
            case 'order.created':
                break;
            case 'order.deleted':
                break;
            case 'order.sales-order-created':
                break;
            case 'order.updated':
                break;
            case 'plugin.after-build':
                break;
            case 'test-event':
                break;
        }

        return true;
    }
}
