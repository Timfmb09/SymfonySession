<?php

namespace App\Controller;


use App\Entity\Session;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $sessions = $doctrine->getRepository(Session::class)->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'sessions' => $sessions

        ]);
    }


    /**
     * @Route("/session/{id}", name="show_session")
     */
    public function show(Session $session): Response { 
        
        return $this->render('session/show.html.twig', [
            
        ]);
    }

}
