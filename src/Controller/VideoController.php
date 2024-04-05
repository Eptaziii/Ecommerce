<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class VideoController extends AbstractController
{
    #[Route('/mod-ajout-video', name: 'app_ajout_video')]
    public function ajoutVideo(Request $request, EntityManagerInterface $em): Response
    {
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em->persist($video);
                $em->flush();
                $this->addFlash('notice','Vidéo ajoutée');
                return $this->redirectToRoute('app_ajout_video');
            }
        }

        return $this->render('video/ajout-video.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
