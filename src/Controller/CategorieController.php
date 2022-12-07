<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="app_categorie")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $categories = $doctrine->getRepository(Categorie::class)->findBy([], ["nomCategorie"=> "ASC"]);
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }
     /**
     * @Route("/categorie/add", name="add_categorie")
     * @Route("/categorie/{id}/edit", name="edit_categorie")
     */
    public function add(ManagerRegistry $doctrine, Categorie $categorie = null, Request $request): Response {
        
        if(!$categorie) {
            $categorie = new Categorie();
        }
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        //si la données est "sanitize" on l'envoi
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $categorie = $form->getData();
            $entityManager = $doctrine->getManager();
            //prepare
            $entityManager->persist($categorie);
            //insert into
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie');
        }
        
        //vue pour afficher le formulaire d'ajout ou d'edition
        return $this->render('categorie/add.html.twig', [
            'formAddCategorie' => $form->createView(),
            'edit' =>$categorie->getId()
        ]);


    }

    /**
     * @Route("/categorie/{id}/delete", name="delete_categorie")
     */
    public function delete(ManagerRegistry $doctrine, Categorie $categorie){

        $entityManager = $doctrine->getManager();
        $entityManager->remove($categorie);
        $entityManager->flush();
        return $this->redirectToRoute('app_categorie');
    }
    /**
     * @Route("/categorie/{id}", name="show_categorie")
     */
    public function show(Categorie $categorie): Response
    { 
  
        return $this->render('categorie/show.html.twig', [
           'categorie'=> $categorie
        ]);
    }

}
