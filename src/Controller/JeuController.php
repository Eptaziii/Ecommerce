<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\JeuxRepository;


class JeuController extends AbstractController
{
    #[Route('/listeJeux', name: 'app_liste-jeux')]
    public function listeJeux(JeuxRepository $jeuxRepository): Response
    {
        $jeux = $jeuxRepository->findAll();
        return $this->render('jeu/liste-jeux.html.twig', [
            'jeux' => $jeux
        ]);
    }
}
