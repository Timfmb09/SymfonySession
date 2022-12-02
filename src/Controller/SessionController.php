<?php

namespace App\Controller;

use App\Entity\Session;
use Doctrine\Persistence\ManagerRegistry;
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
     * @Route("/session"(id), name="show_session")
     */
    public function show(): Response
    { 
        $session = "";
        return $this->render('session/show.html.twig', [
            'session' => $session
        ]);
    }




}
