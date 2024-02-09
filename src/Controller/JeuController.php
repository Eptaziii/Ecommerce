<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JeuController extends AbstractController
{
    #[Route('/listeJeux', name: 'app_liste-jeux')]
    public function listeJeux(): Response
    {
        return $this->render('jeu/liste-jeux.html.twig', [
        ]);
    }
}
