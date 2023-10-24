<?php

namespace App\Twig\Extension;

use App\Repository\CategorieRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }
 
    public function getFunctions(): array
    {
        return [
            new TwigFunction('categorieNav', [$this, 'categorie']),
        ];
    }

    public function categorie(): array
    {
        return $this->categorieRepository->findAll();
    }
}

