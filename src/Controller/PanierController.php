<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Entity\Panier;
use App\Entity\Ajouter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    #[Route('/private-ajout-panier/{id}', name: 'app_ajout_panier')]
    public function ajoutPanier(EntityManagerInterface $em, Jeux $jeu): Response
    {
        if ($this->getUser()->getPanier() == null){
            $panier = new Panier();
            $this->getUser()->setPanier($panier);
        } else {
            $panier = $this->getUser()->getPanier;
        }
        $ajouter = new Ajouter();
        $ajouter->setPanier($panier);
        $ajouter->setJeux($jeu);
        $ajouter->setQuantite(1);
        $panier->addAjouter($ajouter);
        $em -> persist($ajouter);
        $em -> persist($panier);
        $em -> persist($this->getUser());
        $em -> flush();
        return $this->redirectToRoute('app_accueil');
    }
}
