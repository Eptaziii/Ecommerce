<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\JeuxRepository;
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
                    $listJeux[]= $jeu;
                    if ($this->getuser()->getPanier()->getAjouters()->contains($ajouter)) {
                        $this->getUser()->getPanier()->removeAjouter($ajouter);
                    }
                }
                $commande->setNom($this->getUser()->getNom());
                $commande->setPrenom($this->getUser()->getPrenom());
                $commande->setEmail($this->getUser()->getEmail());
                $commande->setDateCommande(new \Datetime());
                $commande->setJeux($listJeux);
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
}
