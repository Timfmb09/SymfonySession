<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="app_user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
            return $this->render('/home.html.twig');
    }

    /**
     * @Route("/membre", name="membre")
     */
    public function membre()
    {
            return $this->render('/membre.html.twig');
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
            return $this->render('/admin.html.twig');
    }



}
