<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Annonces;

class AnnoncesController extends AbstractController
{
    #[Route('/annonces', name: 'app_annonces')]
    public function index(): Response
    {
        return $this->render('annonces/index.html.twig', [
            'controller_name' => 'AnnoncesController',
        ]);
    }

    #[Route('/annonces/add', name:'annonces_add')]
    public function annonces_add(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $annonce = new Annonces();
        $annonce->setTitle("Benett");
        $annonce->setContent("perso support type feu");
        $annonce->setPrix(600);
        $annonce->setCreatedat(new \DateTimeImmutable());

        $entityManager->persist($annonce);
        $entityManager->flush();

        return new Response("Bravo, annonce added");
    }

    #[Route('/annonces/show/{id}', name:'annonces_show')]
    public function show(ManagerRegistry $doctrine, $id)
    {
        $annonce = $doctrine->getRepository(Annonces::class)->find($id);

        return $this->render('annonces/show.html.twig', [
           "annonce" => $annonce 
        ]);
    }

    #[Route('/annonces/delete/{id}', name:'annonces_delete')]
    public function  deleted(ManagerRegistry $doctrine, $id)
    {
        $annonce = $doctrine->getRepository(Annonces::class)->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($annonce);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
}