<?php

namespace App\Controller;

use App\Entity\Session;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/session/add}", name="add_session")
     */
    public function add(ManagerRegistry $doctrine, Session $session = null, Request $request): Response {
        
        $form = $this->createform(SessionType::class, $session);
        $form->handleRequest($request);
        
    


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
