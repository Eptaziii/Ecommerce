<?php

namespace App\Controller;

use App\Entity\Jeux;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    #[Route('/private-vouloir/{id}', name: 'app_vouloir')]
    public function vouloir(Jeux $jeu, EntityManagerInterface $em): Response
    {
        if ($this->getUser()->getVouloirs()->contains($jeu)) {
            $this->getUser()->removeVouloir($jeu);
        } else {
            $this->getUser()->addVouloir($jeu);
        }
        $em->persist($this->getUser());
        $em->flush();
        return $this->redirectToRoute('app_accueil');
    }
}
