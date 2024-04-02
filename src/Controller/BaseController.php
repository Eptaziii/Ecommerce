<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ContactType;
use App\Form\JeuxType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use App\Entity\Jeux;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategorieRepository;
use App\Repository\JeuxRepository;

class BaseController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(CategorieRepository $categorieRepository, JeuxRepository $jeuxRepository): Response
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
}
