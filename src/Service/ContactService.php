<?php

namespace App\Service;

use App\Entity\Contact;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactService extends AbstractController
{
    private $manager; // EntityManagerInterface sert a persister les données dans la BDD

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function persistContact(Contact $contact): void //void return rien ! 
    {
        $contact->setIsSend(false)
                ->setCreatedAt(new DateTime('now'))
        ;
        
        $this->manager->persist($contact);
        $this->manager->flush();
        $this->addFlash('success', 'Votre message est bien envoyé, merci !');   
    }
    
    public function isSend(Contact $contact): void
    {
        $contact->setIsSend(true);

        $this->manager->persist($contact);
        $this->manager->flush();
    }
}