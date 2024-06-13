<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

//    /**
//     * @return Question[] Returns an array of Question objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
    public function getNewIdQuestion(): array 
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT id FROM question ORDER BY id DESC LIMIT 1';

        $resultSet = $conn->executeQuery($sql);

        return $resultSet->fetchAllAssociative();
    }

    public function findByCategorie($value, $id): array 
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT question, id FROM question WHERE question.id_categorie = :val AND question.id = :id';

        $resultSet = $conn->executeQuery($sql, ['val' => $value, 'id' => $id]);

        return $resultSet->fetchAllAssociative();
    }

    public function find_first_id($value): array 
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT id, question FROM question WHERE question.id_categorie = :val LIMIT 1';

        $resultSet = $conn->executeQuery($sql, ['val' => $value]);

        return $resultSet->fetchAllAssociative();
    }
    
    public function find_last_id($value): array 
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT id, question FROM question WHERE question.id_categorie = :val ORDER BY id DESC LIMIT 1';

        $resultSet = $conn->executeQuery($sql, ['val' => $value]);

        return $resultSet->fetchAllAssociative();
    }

//    public function findOneBySomeField($value): ?Question
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
