<?php

namespace App\Controller;

use App\Repository\BlogpostRepository;
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
        
        $data = $blogpostRepository->findAll(); // recupérer tous les articles
        
        $blogposts = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), 6 // dans la requette http la valeur de 'page' par default = 1, limite de 6 articles par page 
        );
        
        
        return $this->render('blogpost/actualites.html.twig', [
            'blogposts' => $blogposts
        ]);
    }
    
    #[Route('/actualites/{slug}', name: 'actualites_detail')]
    public function detail($slug, BlogpostRepository $blogpostRepository): Response
    {
        $blogpost = $blogpostRepository->findOneBy([
            'slug' => $slug
        ]);

        return $this->render('blogpost/detail.html.twig',[
            'blogpost' => $blogpost
        ]);
    }
}
