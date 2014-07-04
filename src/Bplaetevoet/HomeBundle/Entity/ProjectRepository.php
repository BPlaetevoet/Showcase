<?php
// src/Bplaetevoet/HomeBundle/Entity/ProjectRepository.php
namespace Bplaetevoet\HomeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProjectRepository
 */
class ProjectRepository extends EntityRepository{
    Public function findAllOrderedByNaam(){
        return $this->getEntityManager()
                ->createQuery('select p from BplaetevoetHomeBundle:Project p ORDER BY p.naam ASC')
                ->getResult();
    }
    
}

