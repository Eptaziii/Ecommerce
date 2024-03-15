<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Form\ModifierCategorieType;
use App\Form\SupprimerCategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends AbstractController
{
    #[Route('/private-categorie', name: 'app_categorie')]
    public function categorie(Request $request, EntityManagerInterface $em): Response
    {  
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()) {
                $em->persist($categorie);
                $em->flush();
                $this->addFlash('notice','Catégorie ajoutée');
                return $this->redirectToRoute('app_categorie');
            }
        }
        return $this->render('categorie/categorie.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/private-liste-categories', name: 'app_liste-categories', methods: ['GET', 'POST'])]
    public function listeCategories(Request $request, CategorieRepository $categorieRepository,
    EntityManagerInterface $em): Response
    {
        $categories = $categorieRepository->findAll();
        return $this->render('categorie/liste-categories.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/private-modifier-categorie/{id}', name: 'app_modifier_categorie')]
    public function modifierCategorie(Request $request,Categorie $categorie,EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ModifierCategorieType::class, $categorie);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em->persist($categorie);
                $em->flush();
                $this->addFlash('noticej','Catégorie modifiée');
                return $this->redirectToRoute('app_liste-categories');
            }
        }
        return $this->render('categorie/modifier-categorie.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/private-supprimer-categorie/{id}', name: 'app_supprimer_categorie')]
    public function supprimerCategorie(Request $request,Categorie $categorie,EntityManagerInterface $em): Response
    {   
        if($categorie!=null){
            $em->remove($categorie);
            $em->flush();
            $this->addFlash('noticer','Catégorie supprimée');
        }
    return $this->redirectToRoute('app_liste-categories');
    }
}
