<?php
namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Force extends AbstractExtension
{
    public function getFilters()
    {
        return [
        new TwigFilter('force', [$this, 'force']),
    ];
    }
    public function force(array $character): int
    {
        $forces = [
            'Dame' => 1.5,
            'Ennemie' => 1.4,
            'Seigneur' => 1.3,
            'Ennemi' => 1.2,
        ];
        return $character['life'] * $character['intelligence'] * $forces[$character['kind']];
    }
}