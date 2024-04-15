<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Entity\Video;
use App\Form\ModifierJeuxType;
use App\Repository\JeuxRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/mod-modifier-jeu/{id}', name: 'app_modifier_jeu')]
    public function modifierJeux(Request $request,Jeux $jeu,EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ModifierJeuxType::class, $jeu);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em->persist($jeu);
                $em->flush();
                $this->addFlash('noticej','Jeu modifié');
                return $this->redirectToRoute('app_liste-jeux');
            }
        }
        return $this->render('jeu/modifier-jeu.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
