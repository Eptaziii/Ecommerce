<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Entity\Video;
use App\Repository\JeuxRepository;
use App\Repository\VideoRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
    public function jeu(Jeux $jeu, VideoRepository $vr): Response
    { 
        $videos = $vr->findAll();
        return $this->render('jeu/jeu.html.twig', [
            'jeu' => $jeu,
            'videos' => $videos
            
        ]);
    }
}
