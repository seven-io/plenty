<?php

namespace Seven\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;

class SevenController extends Controller
{
    /**
     * @param Twig $twig
     * @return string
     */
    public function getHelloWorldPage(Twig $twig):string
    {
        return $twig->render('Seven::Index');
    }
}