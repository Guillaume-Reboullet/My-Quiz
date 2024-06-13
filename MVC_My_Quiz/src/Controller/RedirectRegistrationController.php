<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RedirectRegistrationController extends AbstractController
{
    #[Route('/redirect/registration', name: 'app_redirect_registration')]
    public function index(): Response
    {
        return $this->render('redirect_registration/index.html.twig', [
        ]);
    }
}
