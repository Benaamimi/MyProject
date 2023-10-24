<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\PeintureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends AbstractController
{
    #[Route('/portfolio', name: 'portfolio')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('portfolio/index.html.twig', [
            'categories' => $categorieRepository->findAll()
        ]);
    }
    
    #[Route('/portfolio/{slug}', name: 'portfolio_categorie')] // le slug vas être recuperer de la categorie
    public function categorie($slug,  PeintureRepository $peintureRepository, CategorieRepository $categorieRepository): Response
    {
        
        $categorie = $categorieRepository->findOneBy([
            'slug' => $slug
        ]);
        $peintures = $peintureRepository->findAllPortfolio($categorie);

        return $this->render('portfolio/categorie.html.twig', [
            'categorie' => $categorie,
            'peintures' => $peintures,
        ]);
    }

}
