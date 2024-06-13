<?php

namespace App\Controller;

use App\Entity\Resultat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UserResponseController extends AbstractController
{
    #[Route('/userResponse/{id_categorie}', name: 'app_user_response', methods: ['POST'])]
    public function PostResponseUser(Request $request, string $id_categorie): RedirectResponse
    {   
        $reponse = $request->get("reponse");
        $id = $request->get("id");
        return $this->redirectToRoute('app_user_response_get', ["reponse" => $reponse, "id" => $id, "id_categorie" => $id_categorie]);
    }

    #[Route('/userResponse/{id_categorie}/{id}/{reponse}', name: 'app_user_response_get', methods: ['GET'])]
    public function GetResponseUser(Request $request, EntityManagerInterface $entityManager, $reponse, $id_categorie, $id): Response
    {   
        if(!isset($_COOKIE['PHPSESSID'])){
            setcookie($id_categorie."/".$id, 'cat'.$id_categorie.'rep'.$reponse, time()+3600*24*7, "/");
        }else{
        
            $id_user = $this->getUser()->getId();
            $entityManager->getRepository(Resultat::class)->insertResponse($id_categorie, $id, $reponse, $id_user); 
        }
        $id++;
        return $this->redirectToRoute('app_question', ["id" => $id, "id_categorie" => $id_categorie]);
    }
    
}