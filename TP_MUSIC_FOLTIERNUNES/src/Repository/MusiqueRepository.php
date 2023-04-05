<?php

namespace App\Repository;

use App\Entity\Musique;
use App\Entity\Genre;
use App\Entity\Album;
use App\Entity\Artiste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @extends ServiceEntityRepository<Musique>
 *
 * @method Musique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Musique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Musique[]    findAll()
 * @method Musique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Musique::class);
    }

    public function save(Musique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Musique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function insert(EntityManagerInterface $entityManager,$titre,$date,$album,$artiste,$genre){
        $musique = new Musique();
        $musique->setTitreMusique($titre);
        $musique->setDate(date_create($date));
        $genrev = $entityManager->getRepository(Genre::class)->find($genre);
        $musique->addGenre($genrev);
        $artistev = $entityManager->getRepository(Artiste::class)->find($artiste);
        $musique->setArtiste($artistev);
        $albumv = $entityManager->getRepository(Album::class)->find($album);
        $musique->setAlbum($albumv);
        $entityManager->persist($musique);
        $entityManager->flush();
    }

//    /**
//     * @return Musique[] Returns an array of Musique objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Musique
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
