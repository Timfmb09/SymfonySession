<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SessionController extends AbstractController
{
    /**
     * @Route("/session", name="app_session")
     */
    public function index(ManagerRegistry $doctrine): Response {   
        //SELECT * FROM session ORDER BY nom ASC
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
     * @Route("/session/addStagiaire/{idSe}/{idSt}", name="add_stagiaire_session", requirements={"idSe"="\d+", "idSt"="\d+"})
     * @ParamConverter("session", options={"mapping": {"idSe": "id"}})
     * @ParamConverter("stagiaire", options={"mapping": {"idSt" : "id"}})        
     */
    public function addStagiaire(ManagerRegistry $doctrine, Session $session, Stagiaire $stagiaire) {

        $em = $doctrine->getManager(); 
        $session->addStagiaire($stagiaire);
        $em->persist($session);
        $em->flush();

    return $this->redirectToRoute('show_session', ['id' => $session->getId()]);

    }

    
    /**
     * @Route("/session/{id}", name="show_session", requirements={"id"="\d+"})
     * @IsGranted("ROLE_USER")
     */
    public function show(Session $session, SessionRepository $sr): Response { 
        
        $nonInscrits = $sr->findNonInscrits($session->getId());

        return $this->render('session/show.html.twig', [
            'session' => $session,
            'nonInscrits' => $nonInscrits
        ]);
    }

}
