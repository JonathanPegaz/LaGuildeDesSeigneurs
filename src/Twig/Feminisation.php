<?php
namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Feminisation extends AbstractExtension{

    public function getFunctions()
    {
        return [
            new TwigFunction('feminisation', [$this, 'feminisation']),
        ];
    }
    public function feminisation(string $gender, string $text): string
    {
        if ('feminine' === $gender) 
        {
            $texts = [
                'il' => 'elle',
                'Il' => 'Elle',
                'connu' => 'connue',
                'fort' => 'forte',
                'Un' => 'Une',
                'un' => 'une',
            ];
            if (array_key_exists($text, $texts)) 
            {
                return $texts[$text];
            }
        }
        return $text;
    }
}
