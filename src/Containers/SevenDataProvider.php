<?php

namespace Seven\Containers;

use Plenty\Plugin\Templates\Twig;

class SevenDataProvider
{
    public function call(Twig $twig): string
    {
        try {
            return $twig->render('Seven::content.ExampleContent');
        } catch (\Exception $e) {
        }
    }
}