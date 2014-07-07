<?php
// src/Bplaetevoet/HomeBundle/Entity/SkillRepository.php
namespace Bplaetevoet\HomeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SkillRepository
 */
class SkillRepository extends EntityRepository{
    public function findAllSkills(){
        return $this->getEntityManager()->getRepository('BplaetevoetHomeBundle:Skill')->findAll();
        
    }
}

