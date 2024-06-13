<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Entity\Categorie;
use App\Entity\Question;
use App\Entity\Resultat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class QuestionController extends AbstractController
{
    #[Route('/question/{id_categorie}/{id}', name: 'app_question')]
    public function index(EntityManagerInterface $entityManager, $id_categorie, $id, Request $request): Response
    {        
        $firstQuestion = $entityManager->getRepository(Question::class)->find_first_id($id_categorie);
        $lastQuestion = $entityManager->getRepository(Question::class)->find_last_id($id_categorie);
        $questions = $entityManager->getRepository(Question::class)->findByCategorie($id_categorie, $id);
        $reponses = $entityManager->getRepository(Reponse::class)->findAll();
        $reponses = $entityManager->getRepository(Reponse::class)->findAll();
        $nextId = $id + 1;
        $previousId = $id - 1;
        $user = $this->getUser();
        
        if(isset($_COOKIE[$id_categorie."/".$id]) && $user == null){
            $cook = true;
        }else{
            $cook = false;
        }

        $categories = $entityManager->getRepository(Categorie::class)->findAll();
        foreach($categories as $value){
            if($value->getId() == $id_categorie){
                $categorie = $value;
            }
        }
        return $this->render('question/index.html.twig', [
            'questions' => $questions,
            'firstQuestion' => $firstQuestion,
            'lastQuestion' => $lastQuestion,
            'reponses' => $reponses,
            'categorie' => $categorie,
            'id' => $id,
            'nextId' => $nextId,
            'id_categorie' => $id_categorie,
            'previousId' => $previousId,
            'cook' => $cook,
        ]);
    }
}