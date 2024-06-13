<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\Resultat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ResultatController extends AbstractController
{
    #[Route('/resultat/{id_categorie}/{id}', name: 'app_resultat')]
    public function index(EntityManagerInterface $entityManager, $id_categorie, $id): Response
    {
        $firstQuestion = $entityManager->getRepository(Question::class)->find_first_id($id_categorie);
        $lastQuestion = $entityManager->getRepository(Question::class)->find_last_id($id_categorie);
        $questions = $entityManager->getRepository(Question::class)->findByCategorie($id_categorie, $id);
        $reponses = $entityManager->getRepository(Reponse::class)->findReponseByCategorie($id_categorie);
        $categories = $entityManager->getRepository(Categorie::class)->findAll();
        foreach($categories as $value){
            if($value->getId() == $id_categorie){
                $categorie = $value;
            }
        }
        $nextId = $id + 1;
        $previousId = $id - 1;

        $user = $this->getUser();
        if($user == null){
            if(isset($_COOKIE[$id_categorie."/".$id])){
                $cookie_value = explode("rep", $_COOKIE[$id_categorie."/".$id])[1];
                $reponse_user = $cookie_value;
            }else{
                // N'A PAS REPONDU A LA QUESTION
                $reponse_user = 0;
            }
            $count = 0;
            foreach($_COOKIE as $cookie){
                $cookie_cat = explode("rep",explode("cat", $cookie)[1])[0];
                $cookie_rep = explode("rep",explode("cat", $cookie)[1])[1];
                if($cookie_cat == $id_categorie){
                    foreach($reponses as $reponse){
                        if($cookie_rep == $reponse['id'] && $reponse['reponse_expected'] == 1){
                            $count++;
                        }
                    }
                }
            }
        }else{
            $id_user = $user->getId();
            $count = $entityManager->getRepository(Resultat::class)->getGoodResponseByCategory($id_categorie);
            $reponse_user = $entityManager->getRepository(Resultat::class)->getResponseByQuestion($id, $id_user);
            if(isset($count[0]['COUNT(reponse_expected)'])){
                $count = $count[0]['COUNT(reponse_expected)'];
            }else{
                $count = 0;
            }
            if(isset($reponse_user[0]['reponse'])){
                $reponse_user = $reponse_user[0]['reponse'];
            }else{
                $reponse_user = 0;
            }
        }
        return $this->render('resultat/index.html.twig', [
            'questions' => $questions,
            'firstQuestion' => $firstQuestion,
            'lastQuestion' => $lastQuestion,
            'reponses' => $reponses,
            'id' => $id,
            'nextId' => $nextId,
            'id_categorie' => $id_categorie,
            'previousId' => $previousId,
            'count' => $count,
            'reponse_user' => $reponse_user,
            'categorie' => $categorie
        ]);
    }
}
