<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ContactController extends AbstractController {

    public $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function afficherContact(Request $request)
        {

        // création nouveau contact 
        $contact = new Contact();

        // Create form est une methode de l'abstract controllerqui permet de generer un formulaire. Cette methode prend en paramètre un formtype
        $form = $this->createForm(ContactType::class, $contact);
        
        $form->handleRequest($request);

        // Vérification des données 
        if($form->isSubmitted() && $form->isValid())
        {
            // Insérer les données dans la BDD

            // persist prépare les données avant de les insérer dans la BDD
            $this->entityManager->persist($contact);

            // Le flush insère réellement dans la BDD
            $this->entityManager->flush();
        }

        return $this->render('contact.html.twig', ['formcontact' => $form->createView()]);
    }

    public function showContact(ContactRepository $repositoryContact)
    {
        $contacts = $repositoryContact->findAll();

        dump($contacts);

        return $this->render('contacts.html.twig', ['contacts' => $contacts]);
    }

}