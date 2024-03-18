<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;  
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Image;
use App\Form\ImageType;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageController extends AbstractController
{
    #[Route('/admin-ajouter-image', name: 'app_ajouter_image')]
    public function ajouterImage(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $file = $form->get('image')->getData();
                if($file){
                    $nomFichierServeur = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
                    $nomFichierServeur = $slugger->slug($nomFichierServeur);
                    $nomFichierServeur = $nomFichierServeur.'-'.uniqid().'.'.$file->guessExtension();
                    try{
                        $image->setNomServeur($nomFichierServeur);
                        $image->setNomOriginal($file->getClientOriginalName());
                        $image->setDateEnvoi(new \Datetime());
                        $image->setExtension($file->guessExtension());
                        $image->setTaille($file->getSize());
                        $em->persist($image);
                        $em->flush();
                        $file->move($this->getParameter('file_directory'), $nomFichierServeur);
                        $this->addFlash('notice', 'Image ajoutée');
                        return $this->redirectToRoute('app_ajouter_image');
                    }
                    catch(FileException $e){
                        $this->addFlash('notice', 'Erreur d\'envoi');
                    }
                }
            }   
        return $this->render('image/ajouter-image.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
