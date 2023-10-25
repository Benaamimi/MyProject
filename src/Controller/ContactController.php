<?php

namespace App\Controller;

use DateTime;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\ContactService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, ContactService $contactService): Response
    {
        $contact = new Contact;
        $form = $this->createForm(ContactType::class, $contact); // creation d'un formulaire lier a l'entity Contact
        $form->handleRequest($request); // analyser la request

        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData(); // recuperer les information du formulaire

            $contactService->persistContact($contact); // Appele la fonction persistContact qui prend l'objet Contact, que j'ai créer dans la class ContactService

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(), // envoyer le formulaire a la vue twig
        ]);
    }
}
