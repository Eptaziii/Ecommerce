<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Form\JeuxType;
use App\Entity\Contact;
use App\Entity\Categorie;
use App\Form\ContactType;
use App\Form\RechercherType;
use App\Repository\JeuxRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(CategorieRepository $categorieRepository, JeuxRepository $jeuxRepository, Request $request, EntityManagerInterface $em): Response
    {
        $jeux = $jeuxRepository->findAll();
        $categories = $categorieRepository->findAll();
        return $this->render('base/index.html.twig', [
            'categories' => $categories,
            'jeux' => $jeux
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request,EntityManagerInterface $em): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $contact->setDateEnvoi(new \Datetime());
                $em->persist($contact);
                $em->flush();
                $this->addFlash('notice','Message envoyé');
                return $this->redirectToRoute('app_contact');
            }
        }

        return $this->render('base/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/mod-ajouter-jeux', name: 'app_ajouter_jeux')]
    public function ajouterJeux(Request $request, EntityManagerInterface $em): Response
    {
        $jeu = new Jeux();
        $form = $this->createForm(JeuxType::class, $jeu);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em->persist($jeu);
                $em->flush();
                $this->addFlash('notice','Jeu ajouté');
                return $this->redirectToRoute('app_ajouter_jeux');
            }
        }    
        return $this->render('base/ajouter-jeux.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/search/{mot}', name: 'app_search')]
    public function search(Request $request, JeuxRepository $jr): Response
    {
        $mot = $request->get('mot');
        $jeux = $jr->recherche($mot);
        return $this->render('base/search.html.twig', [
            'mot'=>$mot,
            'jeux'=> $jeux
        ]);
    }

    #[Route('/recherche', name: 'app_recherche')]
    public function searchMot(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RechercherType::class);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $mot = $form->get('search')->getData();
                return $this->redirectToRoute('app_search', ['mot'=>$mot]);
            }
        }
        return $this->render('base/recherche.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/mentions-legales', name:'app_ml')]
    public function ml(): Response
    {
        return $this->render('base/ml.html.twig');
    }
}
