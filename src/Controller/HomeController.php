<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController{

    public function afficherAccueil()
    {
        return $this->render('accueil.html.twig', []);
    }
}