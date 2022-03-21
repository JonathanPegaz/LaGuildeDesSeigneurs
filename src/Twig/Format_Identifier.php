<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Format_Identifier extends AbstractExtension
{
    public function getFilters()
    {
        return [new TwigFilter('format_identifier', [$this, 'format_identifier']),];
    }
    public function format_identifier(string $identifier): string
    {

        return substr(chunk_split($identifier, 4, '-'), 0, -1);;
    }
}