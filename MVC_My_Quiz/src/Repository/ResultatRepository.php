<?php

namespace App\Repository;

use App\Entity\Resultat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Resultat>
 */
class ResultatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resultat::class);
    }

//    /**
//     * @return Resultat[] Returns an array of Resultat objects
//     */
public function insertResponse($id_categorie, $id_question, $reponse, $id_user): array 
{
    $insert = ['false'];

    try {
        $insert = ['true'];

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'INSERT INTO resultat (id_categorie, id_question, reponse, id_user) VALUES (:id_categorie, :id_question, :reponse, :id_user)';

        $conn->executeQuery($sql, ['id_categorie' => $id_categorie, 'id_question' => $id_question, 'reponse' => $reponse, 'id_user' => $id_user]);
    } catch (\Throwable $th) {
        throw $th;
    }

    return $insert;
}
public function getGoodResponseByCategory($id_categorie): array 
{
    try {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT COUNT(reponse_expected) FROM reponse INNER JOIN resultat ON reponse.id = resultat.reponse WHERE resultat.id_categorie = :id_categorie AND reponse_expected = 1 GROUP BY reponse_expected;';

        $resultSet = $conn->executeQuery($sql, ['id_categorie' => $id_categorie]);
        return $resultSet->fetchAllAssociative();
    } catch (\Throwable $th) {
        throw $th;
    }
}

public function getResponseByQuestion($id_question, $id_user): array 
{
    try {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT reponse FROM resultat WHERE resultat.id_question = :id_question AND resultat.id_user = :id_user;';

        $resultSet = $conn->executeQuery($sql, ['id_question' => $id_question, 'id_user' => $id_user]);
        return $resultSet->fetchAllAssociative();
    } catch (\Throwable $th) {
        throw $th;
    }
}

public function getCategorieHistorique($id_user): array 
{
    try {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT id_categorie FROM resultat WHERE id_user = :id_user GROUP BY id_categorie;';

        $resultSet = $conn->executeQuery($sql, ['id_user' => $id_user]);
        
        return $resultSet->fetchAllAssociative();
    } catch (\Throwable $th) {
        throw $th;
    }
}
}
