<?php

namespace App\Controller;

use App\Repository\PeintureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeintureController extends AbstractController
{
    #[Route('/realisations', name: 'realisations')]
    public function realisations(PeintureRepository $peintureRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $data = $peintureRepository->findAll(); // recupérer toutes les peintures

        $peintures = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), 6 // par default recupérer la première page, limite de 6 peintures par page
        );

        return $this->render('peinture/realisations.html.twig', [
            'peintures' => $peintures,
        ]);
    }
}
