<?php

namespace Seven\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Log\Loggable;
use Plenty\Plugin\Templates\Twig;

class SevenController extends Controller
{
    use Loggable;

    /**
     * @param Twig $twig
     * @return string
     */
    public function getHelloWorldPage(Twig $twig):string
    {
        $this->getLogger('seven')->debug('getHelloWorldPage');

        return $twig->render('Seven::Index');
    }
}
