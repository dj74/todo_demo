<?php

namespace App\Repository;

use App\Entity\TodoItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TodoItem>
 *
 * @method TodoItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method TodoItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method TodoItem[]    findAll()
 * @method TodoItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodoItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TodoItem::class);
    }

    public function save(TodoItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TodoItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getAllPendingTodoItems(): array
    {
        return $this->getTodoItems(0, 'creation_ts');
    }

    public function getAllOngoingTodoItems(): array
    {
        return $this->getTodoItems(1, 'start_ts');
    }

    public function getAllCompletedTodoItems(): array
    {
        return $this->getTodoItems(2, 'completed_ts');
    }

    private function getTodoItems(int $status, string $timestampForSorting): array
    {
        return $this->createQueryBuilder('todo_items')
                    ->where('todo_items.status=:val')
                    ->setParameter('val', $status)
                    ->orderBy('todo_items.'.$timestampForSorting, 'ASC')
                    ->getQuery()
                    ->getResult();
    }

    public function findById(int $id): ?TodoItem
    {
        return $this->createQueryBuilder('todo_items')
                    ->where('todo_items.id=:val')
                    ->setParameter('val', $id)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TodoItem
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
