<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\JeuxRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function commande(Request $request,EntityManagerInterface $em, JeuxRepository $jr): Response
    {
        $jeux=$jr->findAll();
        $panier=$this->getUser()->getPanier()->getAjouters();
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                foreach ($this->getUser()->getPanier()->getAjouters() as $ajouter) {
                    $jeu=$ajouter->getJeux()->getNom();
                    $qte=$ajouter->getQuantite();
                    $listJeux[]= [$jeu,$qte];
                    $prixJeuUnit=$ajouter->getJeux()->getPrix();
                    $prixJeuQte[]=$prixJeuUnit*$qte;
                    if ($this->getuser()->getPanier()->getAjouters()->contains($ajouter)) {
                        $this->getUser()->getPanier()->removeAjouter($ajouter);
                    }
                }
                $prixTT=array_sum($prixJeuQte);
                $commande->setNom($this->getUser()->getNom());
                $commande->setPrenom($this->getUser()->getPrenom());
                $commande->setEmail($this->getUser()->getEmail());
                $commande->setDateCommande(new \Datetime());
                $commande->setJeux($listJeux);
                $commande->setPrix($prixTT);
                $em->persist($this->getUser());
                $em->persist($commande);
                $em->flush();
                $this->addFlash('notice','Commande envoyée');
                return $this->redirectToRoute('app_accueil');
            }
        }
        return $this->render('commande/commande.html.twig', [
            'form' => $form->createView(),
            'jeux' => $jeux,
            'panier' => $panier
        ]);
    }

    #[Route('/liste-commandes', name: 'app_liste_commandes')]
    public function listeCommandes(CommandeRepository $cr, JeuxRepository $jr): Response
    {
        $commandes=$cr->findAll();
        $jeux=$jr->findAll();
        return $this->render('commande/liste-commandes.html.twig', [
            'commandes'=>$commandes,
            'jeux'=>$jeux
        ]);
    }
}
