<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    /**
     * @Route("/session", name="app_session")
     */
    public function index(ManagerRegistry $doctrine): Response
    {   //SELECT * FROM session ORDER BY nom ASC
        $sessions = $doctrine->getRepository(Session::class)->findBy([], ["nomSession" => "ASC"]);
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions
        ]);
    }

    /**
     * @Route("/session/add", name="add_session")
     */
    public function add(ManagerRegistry $doctrine, Session $session = null, Request $request): Response {
        
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);
        //si la données est "sanitize" on l'envoi
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $session = $form->getData();
            $entityManager = $doctrine->getManager();
            //prepare
            $entityManager->persist($session);
            //insert into
            $entityManager->flush();

            return $this->redirectToRoute('app_session');
        }
        
        //vue pour afficher le formulaire d'ajout
        return $this->render('session/add.html.twig', [
            'formAddSession' => $form->createView()
        ]);


    }
    /**
     * @Route("/session/{id}", name="show_session")
     */
    public function show(Session $session): Response
    { 
        
        return $this->render('session/show.html.twig', [
            'session' => $session
        ]);
    }

}
