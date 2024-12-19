<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Niveau;
use App\Entity\Classe;
use App\Entity\Professeur;
use App\Repository\CoursRepository;
use App\Repository\NiveauRepository;
use App\Repository\ClasseRepository;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    public function creerCours(Request $request, EntityManagerInterface $em): Response
    {
        #[Route('index.Cours', name: 'cours_index')]

        if ($request->isMethod('POST')) {
            $cours = new Cours();
            $cours->setProfesseur($request->request->get('professeur')); 
            $cours->setClasse($request->request->get('classe')); 

            $em->persist($cours);
            $em->flush();

            $this->addFlash('Cours créé avec succès !');
            return $this->redirectToRoute('cours');
        }

        return $this->render('/cours.html.twig', []);
    }

    #[Route('index.niveau', name: 'niveau_index')]
    public function createNiveau(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $niveau = new Niveau();
            $niveau->setLibelle($request->request->get('libelle'));

            $em->persist($niveau);
            $em->flush();

            $this->addFlash( 'Niveau créé avec succès !');
            return $this->redirectToRoute('niveau');
        }

        return $this->render('/niveau.html.twig', []);
    }

    #[Route('index.cours/niveau/{id}', name: 'cours_niveau')]
    public function ListerCoursParNiveau(Niveau $niveau, CoursRepository $coursRepo): Response
    {
        $cours = $coursRepo->findBy(['niveau' => $niveau]);

        return $this->render('niveau.html.twig', [
            'niveau' => $niveau,
            'cours' => $cours,
        ]);
    }

    #[Route('index.cours/classe/{id}', name: 'coursclasse')]
    public function ListerCoursParClasse(Classe $classe, CoursRepository $coursRepo): Response
    {
        $cours = $coursRepo->findBy(['classe' => $classe]);

        return $this->render('cours.html.twig', [
            'classe' => $classe,
            'cours' => $cours,
        ]);
    }

    #[Route('index.cours/professeur/{id}', name: 'coursparprofesseur', methods: ['GET'])]
    public function afficherCoursParProfesseur(Professeur $professeur, CoursRepository $coursRepo): Response
    {
        $cours = $coursRepo->findBy(['professeur' => $professeur]);

        return $this->render('professeur.html.twig', [
            'professeur' => $professeur,
            'cours' => $cours,
        ]);
    }
}