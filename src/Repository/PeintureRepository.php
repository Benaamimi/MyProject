<?php

namespace App\Repository;

use App\Entity\Categorie;
use App\Entity\Peinture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Peinture>
 *
 * @method Peinture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Peinture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Peinture[]    findAll()
 * @method Peinture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeintureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Peinture::class);
    }

   /**
    * @return Peinture[] Returns an array of Peinture objects
    */
   public function lastTree(): array // les dernieres 3 peintures
   {
       return $this->createQueryBuilder('p') 
           ->orderBy('p.id', 'DESC') // ordonner par id de façon décroissants
           ->setMaxResults(3) // retourner 3 resultat au maximum
           ->getQuery() // faire la query
           ->getResult() // recupérer les resultats
       ;
   }

   /**
    * @return Peinture[] Returns an array of Peinture objects
    */
   public function findAllPortfolio(Categorie $categorie): array 
   {
       return $this->createQueryBuilder('p') // fabriquer une requette
           ->where(':categorie MEMBER OF p.categorie') // ça doit être dans la categorie
        //    ->andWhere('p.portfolio = TRUE') // ça doit être true
           ->setParameter('categorie', $categorie) 
           ->getQuery() // faire la query
           ->getResult() // recupérer les resultats 
       ;
   }


}
