<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Categorie;
use App\Entity\Question;
use App\Entity\Resultat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoriesController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function getAll(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categorie::class)->findAll();
        
        $idFirstQuestion = [];
        foreach ($categories as $categorie) {
            $idFirstQuestion[$categorie->getId()] = $entityManager->getRepository(Question::class)->find_first_id($categorie->getId());
        }
        $categoriesWithQuestions = [];
        foreach ($categories as $categorie) {
            $categoriesWithQuestions[] = [
                'category' => $categorie,
                'firstQuestionId' => $idFirstQuestion[$categorie->getId()][0],
            ];
        }
        $historique = array();
        $user = $this->getUser();
        if(isset($_COOKIE) && $user == null){
            if(!isset($_COOKIE['sf_redirect'])){
            foreach($_COOKIE as $cookie){
                    $cookie_cat = explode("rep",explode("cat", $cookie)[1])[0];
                    foreach($categories as $categorie){
                        if($cookie_cat == $categorie->getId()){
                            $historique[] = [
                                'categorieId' => $categorie->getId(),
                                'categorieName' => $categorie->getName(),
                                'firstQuestionId' => $idFirstQuestion[$categorie->getId()][0]['id'],
                            ];
                        }
                    }
                }
            }
            $arr_tmp = array();
            $historique_vf = array();
            $historique_length = count($historique);
            asort($historique);
            for($i = 0; $i < $historique_length; $i++){
                if(isset($historique[0]) && isset($historique[1]) && $historique[0]['categorieName'] !== $historique[1]['categorieName']){
                    array_push($historique_vf, $historique[0]);
                    array_shift($historique);
                }
                if(isset($historique[0]) && isset($historique[1]) && $historique[0]['categorieName'] == $historique[1]['categorieName']){
                    array_push($arr_tmp, $historique[0]);
                    array_shift($historique);
                }
                if(count($historique) == 1){
                    array_push($historique_vf, $historique[0]);
                    array_shift($historique);
                }
            }
        }else{
            $historique_vf = array();
            $categoriesHistorique = $entityManager->getRepository(Resultat::class)->getCategorieHistorique($user->getId());
            foreach($categories as $categorie){
                foreach($categoriesHistorique as $value){
                    if($value['id_categorie'] == $categorie->getId()){
                        $historique_vf[] = [
                            'categorieId' => $categorie->getId(),
                            'categorieName' => $categorie->getName(),
                            'firstQuestionId' => $idFirstQuestion[$categorie->getId()][0]['id'],
                        ];
                    }
                }
            }
        }
        return $this->render('index/index.html.twig', [
            'categoriesWithQuestions' => $categoriesWithQuestions,
            'historique' => $historique_vf,
        ]);
    }
}
