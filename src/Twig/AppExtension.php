<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('uploads', [$this, 'uploads']),
        ];
    }

    public function uploads($path, $type = 'pdf')
    {
        if ($type === 'xml') {
            return '/s-factura/public/uploads/xmls/' . $path;
        }
        return '/s-factura/public/uploads/pdfs/' . $path;
    }
    
    

}
