<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Entity\Panier;
use App\Entity\Ajouter;
use App\Repository\JeuxRepository;
use App\Repository\PanierRepository;
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
            $panier = $this->getUser()->getPanier();
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
        $this->addFlash('notice',$jeu->getNom().' ajouté au panier');
        return $this->redirectToRoute('app_accueil');
    }

    #[Route('/private-ajout-panier-page/{id}', name: 'app_ajout_panier_page')]
    public function ajoutPanierPage(EntityManagerInterface $em, Jeux $jeu): Response
    {
        if ($this->getUser()->getPanier() == null){
            $panier = new Panier();
            $this->getUser()->setPanier($panier);
        } else {
            $panier = $this->getUser()->getPanier();
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
        $this->addFlash('notice',$jeu->getNom().' ajouté au panier');
        return $this->redirectToRoute('app_jeu', ['id'=> $jeu->getId()]);
    }

    #[Route('/private-ajout-panier-favoris/{id}', name: 'app_ajout_panier_favoris')]
    public function ajoutPanierfavoris(EntityManagerInterface $em, Jeux $jeu): Response
    {
        if ($this->getUser()->getPanier() == null){
            $panier = new Panier();
            $this->getUser()->setPanier($panier);
        } else {
            $panier = $this->getUser()->getPanier();
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
        $this->addFlash('notice',$jeu->getNom().' ajouté au panier');
        return $this->redirectToRoute('app_liste_favoris');
    }

    #[Route('/private-supp-panier-page/{id}', name:'app_supp_panier_page')]
    public function suppPanierPage(EntityManagerInterface $em, Jeux $jeu): Response
    {
        foreach ($this->getUser()->getPanier()->getAjouters() as $ajouter) {
            if ($this->getuser()->getPanier()->getAjouters()->contains($ajouter)) {
                if ($ajouter->getJeux() == $jeu) {
                    $this->getUser()->getPanier()->removeAjouter($ajouter);
                }
            }
        }
        $em->persist($this->getUser());
        $em->flush();
        $this->addFlash('noticer',$jeu->getNom().' supprimé du panier');
        return $this->redirectToRoute('app_jeu', ['id' => $jeu->getId()]);
    }

    #[Route('/private-supp-panier-panier/{id}', name:'app_supp_panier_panier')]
    public function suppPanierPanier(EntityManagerInterface $em, Jeux $jeu): Response
    {
        foreach ($this->getUser()->getPanier()->getAjouters() as $ajouter) {
            if ($this->getuser()->getPanier()->getAjouters()->contains($ajouter)) {
                if ($ajouter->getJeux() == $jeu) {
                    $this->getUser()->getPanier()->removeAjouter($ajouter);
                }
            }
        }
        $em->persist($this->getUser());
        $em->flush();
        $this->addFlash('noticer',$jeu->getNom().' supprimé du panier');
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/private-supp-panier-accueil/{id}', name:'app_supp_panier_accueil')]
    public function suppPanierAccueil(EntityManagerInterface $em, Jeux $jeu): Response
    {
        foreach ($this->getUser()->getPanier()->getAjouters() as $ajouter) {
            if ($this->getuser()->getPanier()->getAjouters()->contains($ajouter)) {
                if ($ajouter->getJeux() == $jeu) {
                    $this->getUser()->getPanier()->removeAjouter($ajouter);
                }
            }
        }
        $em->persist($this->getUser());
        $em->flush();
        $this->addFlash('noticer',$jeu->getNom().' supprimé du panier');
        return $this->redirectToRoute('app_accueil');
    }

    #[Route('/private-supp-panier-favoris/{id}', name:'app_supp_panier_favoris')]
    public function suppPanierFavoris(EntityManagerInterface $em, Jeux $jeu): Response
    {
        foreach ($this->getUser()->getPanier()->getAjouters() as $ajouter) {
            if ($this->getUser()->getPanier()->getAjouters()->contains($ajouter)) {
                if ($ajouter->getJeux() == $jeu) {
                    $this->getUser()->getPanier()->removeAjouter($ajouter);
                }
            }
        }
        $em->persist($this->getUser());
        $em->flush();
        $this->addFlash('noticer',$jeu->getNom().' supprimé du panier');
        return $this->redirectToRoute('app_liste_favoris');
    }

    #[Route('/private-panier', name: 'app_panier')]
    public function panier(JeuxRepository $jr): Response
    {
        $jeux = $jr->findAll();
        $panier= $this->getUser()->getPanier()->getAjouters();
        return $this->render('panier/panier.html.twig', [
            'panier'=> $panier,
            'jeux'=> $jeux
        ]);
    }

    #[Route('/private-ajout-quantite/{id}', name: 'app_ajout_quantite')]
    public function ajoutQuantite(EntityManagerInterface $em, Jeux $jeu): Response
    {
        foreach ($this->getUser()->getPanier()->getAjouters() as $ajouter) {
            if ($this->getUser()->getPanier()->getAjouters()->contains($ajouter)) {
                if ($ajouter->getJeux() == $jeu) {
                    $ajouter->setQuantite($ajouter->getQuantite()+1);
                }
            }
        }
        $em->persist($this->getUser());
        $em->flush();
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/private-supp-quantite/{id}', name: 'app_supp_quantite')]
    public function suppQuantite(EntityManagerInterface $em, Jeux $jeu): Response
    {
        foreach ($this->getUser()->getPanier()->getAjouters() as $ajouter) {
            if ($this->getUser()->getPanier()->getAjouters()->contains($ajouter)) {
                if ($ajouter->getJeux() == $jeu) {
                    if ($ajouter->getQuantite() > 1) {
                        $ajouter->setQuantite($ajouter->getQuantite()-1);
                    }
                }
            }
        }
        $em->persist($this->getUser());
        $em->flush();
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/private-commander', name:'app_commander')]
    public function commander(EntityManagerInterface $em): Response
    {
        foreach ($this->getUser()->getPanier()->getAjouters() as $ajouter) {
            if ($this->getuser()->getPanier()->getAjouters()->contains($ajouter)) {
                $this->getUser()->getPanier()->removeAjouter($ajouter);
            }
        }
        $em->persist($this->getUser());
        $em->flush();
        $this->addFlash('notice',' Commande passée');
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/private-supp-panier-all', name:'app_supp_panier_all')]
    public function suppPanierAll(EntityManagerInterface $em): Response
    {
        foreach ($this->getUser()->getPanier()->getAjouters() as $ajouter) {
            if ($this->getuser()->getPanier()->getAjouters()->contains($ajouter)) {
                $this->getUser()->getPanier()->removeAjouter($ajouter);
            }
        }
        $em->persist($this->getUser());
        $em->flush();
        $this->addFlash('noticer','Tous les jeux ont été supprimé du panier');
        return $this->redirectToRoute('app_panier');
    }
}
