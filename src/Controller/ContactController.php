<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use App\Form\Type\ContactUpdate;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Routing\Annotation\Route;

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

            // Affiche un message flash de succès 
            $this->addFlash('success', 'Super ! Le contact a bien été ajouté !');

            // La méthode redirectToRoute redirige vers une route 
            return $this->redirectToRoute('contacts');
        }

        return $this->render('contact.html.twig', ['formcontact' => $form->createView()]);
    }

    public function showContact(ContactRepository $repositoryContact)
    {
        $contacts = $repositoryContact->findAll();

        return $this->render('contacts.html.twig', ['contacts' => $contacts]);
    }

    // Fonction delete

    /**
     * @Route("/delete/{id}", methods={"GET"}, name="contactdelete")
     */
    #[Route('/delete/{id}', name: 'contactdelete')]
    public function deleteContact(ContactRepository $contactRepository, $id)
    {
        $contact = $contactRepository->find($id);

        if ($contact){

            $contactRepository->remove($contact, $flush = True);

            $this->addFlash('success', 'Bravo ! Le contact a bien été supprimé !');

            return $this->redirectToRoute('contacts');
        }

        // Si l'id n'existe pas : 
        return $this->redirectToRoute('contacts');
    }

    //Fonction update 

    #[Route('/update/{id}', name: 'contactupdate')]
    public function modifyContact(Request $request, ContactRepository $contactRepository, $id)
    {

        // Récupérer l'entité à mettre à jour pour préremplir 
        $contact = $contactRepository->find($id);

        // Creation du formulaire de modification 
        // $contact pour préremplir les infos du formulaire 
        $form = $this->createForm(ContactUpdate::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // Modifier les données 
            $contactRepository->save($contact, $flush = true);

            // Afficher message de succès 
            $this->addFlash('success', 'Génial ! Le contact a bien été modifié !');
            // Redirection 
            return $this->redirectToRoute('contacts');
        }

        return $this->render('update.html.twig', ['formupdate' => $form->createview()]);
    }

}