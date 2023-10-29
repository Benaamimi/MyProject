<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\BlogpostRepository;
use App\Repository\CommentaireRepository;
use App\Service\CommentaireService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogpostController extends AbstractController
{
    #[Route('/actualites', name: 'actualites')]
    public function actualites(BlogpostRepository $blogpostRepository, PaginatorInterface $paginator, Request $request): Response
    {
        
        $data = $blogpostRepository->findBy([], ['id' => 'DESC']); // recupérer tous les articles
        
        $blogposts = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), 6 // dans la requette http la valeur de 'page' par default = 1, limite de 6 articles par page 
        );
        
        
        return $this->render('blogpost/actualites.html.twig', [
            'blogposts' => $blogposts
        ]);
    }
    
    #[Route('/actualites/{slug}', name: 'actualites_detail')]
    public function detail($slug, BlogpostRepository $blogpostRepository, Request $request, CommentaireService $commentaireService, CommentaireRepository $commentaireRepository): Response
    {
        $blogpost = $blogpostRepository->findOneBy([
            'slug' => $slug
        ]);

        $commentaires = $commentaireRepository->findCommentaires($blogpost);
        $commentaire = new Commentaire;

        $form = $this->createForm(CommentaireType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $commentaire = $form->getData();

            $commentaireService->persistCommentaire($commentaire, $blogpost, null); 

            return $this->redirectToRoute('actualites_detail', [
                'slug' => $blogpost->getSlug()
            ]);
        }

        return $this->render('blogpost/detail.html.twig',[
            'blogpost' => $blogpost,
            'form' => $form->createView(),
            'commentaires' => $commentaires
        ]);
    }

}
