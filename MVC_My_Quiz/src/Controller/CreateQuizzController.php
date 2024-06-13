<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Question;
use App\Entity\Reponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;

class CreateQuizzController extends AbstractController
{
    #[Route('/create/quizz', name: 'app_create_quizz')]
    public function index(): Response
    {
        return $this->render('create_quizz/index.html.twig', [
        ]);
    }

    #[Route('/get_new_quizz', name: 'app_get_new_quizz', methods: ['POST'])]
    public function GetNewQuizz(Request $request, EntityManagerInterface $entityManager): Response
    {
        $all_info = $request->request->all();

        //INSERT INTO CATEGORIE
        $title = new Categorie;
        $titre = $request->get("titre");
        $title->setName($titre);
        $entityManager->persist($title);
        $entityManager->flush();


        $organizedQuestions = [];
        $allResponses = [];
        $OrganizedResponses = [];
        $organizedReponseExpected = [];
        $organizedData = [];

        //SORT QUESTIONS
        foreach ($all_info as $key => $value) {
            if (explode("_", $key)[0] === "question") {
                array_push($organizedQuestions, $value);
            }
        }

        //SORT RESPONSES
        foreach ($all_info as $key => $value) {
            if (explode("_", $key)[0] === "reponse") {
                array_push($allResponses, $value);
            }
        }

        $allResponses_length = count($allResponses);

        for ($i = 0; $i < $allResponses_length; $i++) {
            if (isset($allResponses[0])) {
                $array_tmp = [];
                for ($j = 0; $j < 4; $j++) {
                    array_push($array_tmp, $allResponses[0]);
                    array_shift($allResponses);
                }
            } else {
                break;
            }
            $OrganizedResponses[$i] = $array_tmp;
        }


        //GET REPONSE_EXPECTED  
        foreach ($all_info as $key => $value) {
            if (explode("_", $key)[0] === "reponseExpected") {
                array_push($organizedReponseExpected, $value);
            }
        }

        //GET ORGANIZEDRESPONSES
        foreach ($organizedReponseExpected as $key => $value) {
            for ($i = 0; $i < $value - 1; $i++) {
                $array_tmp = [];
                array_push($array_tmp, $OrganizedResponses[$key][0]);
                array_shift($OrganizedResponses[$key]);
                array_push($OrganizedResponses[$key], $array_tmp[0]);
            }
        }

        //GET FINAL ARRAY WITH ALL DATA ORGANIZED
        $organized_questions_length = count($organizedQuestions);
        for ($i = 0; $i < $organized_questions_length; $i++) {
            $organizedData[$organizedQuestions[$i]] = $OrganizedResponses[$i];
        }

        //GET ID_CATEGORIE FROM NEWLY INSERTED CATEGORIE TITLE
        $id_new_categorie = $entityManager->getRepository(Categorie::class)->getNewIdCategorie();

        //FLUSH QUESTION AND ASSIOCIATE RESPONSES (FIRST RESPONSE === REPONSE_EXPECTED)
        foreach ($organizedData as $key => $value) {
            $question = new Question;
            $question->setQuestion($key);
            $question->setId_categorie($id_new_categorie[0]['id']);
            $entityManager->persist($question);
            $entityManager->flush();

            //GET ID_QUESTION FROM NEWLY INSERTED QUESTION
            $id_new_question = $entityManager->getRepository(Question::class)->getNewIdQuestion();

            foreach ($value as $key => $reponse) {
                if ($key == 0) {
                    $reponseToFlush = new Reponse;
                    $reponseToFlush->setIdQuestion($id_new_question[0]['id']);
                    $reponseToFlush->setReponse_expected(1);
                    $reponseToFlush->setReponse($reponse);
                    $entityManager->persist($reponseToFlush);
                    $entityManager->flush();
                }else{
                    $reponseToFlush = new Reponse;
                    $reponseToFlush->setIdQuestion($id_new_question[0]['id']);
                    $reponseToFlush->setReponse_expected(0);
                    $reponseToFlush->setReponse($reponse);
                    $entityManager->persist($reponseToFlush);
                    $entityManager->flush();
                }
            }
        }
        return $this->redirectToRoute('app_index');
    }
}
