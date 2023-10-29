<?php

namespace App\Controller;

use App\Entity\Peinture;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Service\CommentaireService;
use App\Repository\PeintureRepository;
use App\Repository\CommentaireRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PeintureController extends AbstractController
{
    #[Route('/realisations', name: 'realisations')]
    public function realisations(PeintureRepository $peintureRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $data = $peintureRepository->findBy([], ['id' => 'DESC']); // recupérer toutes les peintures

        $peintures = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), 6 // par default recupérer la première page, limite de 6 peintures par page
        );

        return $this->render('peinture/realisations.html.twig', [
            'peintures' => $peintures,
        ]);
    }

    #[Route('/realisations/{slug}', name: 'realisations_details')]
    public function details($slug, PeintureRepository $peintureRepository,  Request $request, CommentaireService $commentaireService, CommentaireRepository $commentaireRepository): Response
    {
        $peinture = $peintureRepository->findOneBy([
            'slug' => $slug
        ]);

        $commentaires = $commentaireRepository->findCommentaires($peinture);
        $commentaire = new Commentaire;

        $form = $this->createForm(CommentaireType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $commentaire = $form->getData();

            $commentaireService->persistCommentaire($commentaire, $peinture, null); 

            return $this->redirectToRoute('realisations_details', [
                'slug' => $peinture->getSlug()
            ]);
        }
        return $this->render('peinture/details.html.twig', [
            'peinture' => $peinture,
            'form' => $form->createView(),
            'commentaires' => $commentaires
        ]);
    }

}

