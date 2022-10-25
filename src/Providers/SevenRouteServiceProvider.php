<?php

namespace Seven\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

/**
 * Class SevenRouteServiceProvider
 * @package Seven\Providers
 */
class SevenRouteServiceProvider extends RouteServiceProvider
{
    /**
     * @param Router $router
     */
    public function map(Router $router)
    {
        $router->get('hello-world','Seven\Controllers\SevenController@getHelloWorldPage');
    }
}