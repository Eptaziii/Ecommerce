<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\JeuxRepository;
use App\Entity\Jeux;


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

    #[Route('/jeu/{id}', name: 'app_jeu')]
    public function jeu(Jeux $jeu): Response
    {
        return $this->render('jeu/jeu.html.twig', [
            'jeu' => $jeu
        ]);
    }
}
