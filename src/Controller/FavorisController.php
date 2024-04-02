<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Entity\User;
use App\Repository\JeuxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavorisController extends AbstractController
{
    #[Route('/private-aimer/{id}', name: 'app_aimer')]
    public function aimer(Jeux $jeu, EntityManagerInterface $em): Response
    {
        if ($this->getUser()->getAimer()->contains($jeu)) {
            $this->getUser()->removeAimer($jeu);
        } else {
            $this->getUser()->addAimer($jeu);
        }
        $em->persist($this->getUser());
        $em->flush();
        return $this->redirectToRoute('app_accueil');
    }

    #[Route('/private-liste-favoris', name: 'app_liste_favoris')]
    public function favoris(JeuxRepository $jr): Response
    {
        $favoris=$this->getUser()->getAimer();
        return $this->render('favoris/liste-favoris.html.twig', [
            'favoris'=> $favoris
        ]);
    }
}
