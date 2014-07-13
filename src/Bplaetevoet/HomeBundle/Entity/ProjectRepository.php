<?php
// src/Bplaetevoet/HomeBundle/Entity/ProjectRepository.php
namespace Bplaetevoet\HomeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProjectRepository
 */
class ProjectRepository extends EntityRepository{
    public function findAllOrderedByNaam(){
        return $this->getEntityManager()
                ->createQuery('select p from BplaetevoetHomeBundle:Project p ORDER BY p.naam ASC')
                ->getResult();
    }
    public function findprojectskills(){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select("p.naam, count(s)as AANTAL From BplaetevoetHomeBundle:Project p  INNER JOIN BplaetevoetHomeBundle:Skill s WHERE s in ('p.skills') "); 
        return $qb;
    }
    
}

