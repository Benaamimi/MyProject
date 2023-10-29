<?php

namespace App\Service;

use App\Entity\Blogpost;
use App\Entity\Commentaire;
use App\Entity\Contact;
use App\Entity\Peinture;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaireService extends AbstractController
{
    private $manager; // EntityManagerInterface sert a persister les données dans la BDD

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function persistCommentaire(Commentaire $commentaire, Blogpost $blogpost = null, Peinture $peinture = null): void //void return rien ! 
    {
        $commentaire->setIsPublished(false) // pas publier par défault
                    ->setPeinture($peinture)
                    ->setBlogpost($blogpost)
                    ->setCreatedAt(new \DateTime())
        ;
        
        $this->manager->persist($commentaire);
        $this->manager->flush();
        $this->addFlash('success', 'Votre commentaire est bien envoyé, merci !');   
    }
    
}