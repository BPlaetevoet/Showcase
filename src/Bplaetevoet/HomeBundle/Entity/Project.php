<?php
// src/Bplaetevoet/HomeBundle/Entity/Project.php
namespace Bplaetevoet\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Project
 * @ORM\HaslifecycleCallbacks() 
 * @ORM\Entity(repositoryClass="Bplaetevoet\HomeBundle\Entity\ProjectRepository")
 * @ORM\Table(name="projects")
 */
class Project{
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=100)
     */
    protected $naam;
    
    /**
     * @var text
     * 
     * @ORM\Column(type="text")
     */
    protected $omschrijving;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=100)
     */
    protected $url;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=100)
     */
    protected $afbeelding;
    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Skill", mappedBy="project", cascade={"persist"})
     * @ORM\JoinTable(name="skill_project")
     */
    protected $skills;
    
    /**
     * @var datetime
     * @ORM\Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    protected $datecreated;
    
    /**
     * @return integer
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     * Set naam
     * 
     * @param string $naam
     * @return Project
     */
    public function setNaam($naam){
        $this->naam = $naam;
        return $this;
    }
    /**
     * Get naam
     * 
     * @return string
     */
    public function getNaam(){
        return $this->naam;
    }
    /**
     * Set omschrijving
     *
     * @param text $omschrijving
     * @return Project
     */
    public function setOmschrijving($omschrijving)
    {
        $this->omschrijving = $omschrijving;

        return $this;
    }

    /**
     * Get omschrijving
     *
     * @return text 
     */
    public function getOmschrijving()
    {
        return $this->omschrijving;
    }
    
    /**
     * Set url
     * 
     * @param string $url
     * @return Project
     */
    public function setUrl($url){
        $this->url = $url;
        return $this;
    }
    
    /**
     * Get url
     * 
     * @return string
     */
    public function getUrl(){
        return $this->url;
    }
    
    /**
     * Set afbeelding
     * 
     * @param string $afbeelding
     * @return Project
     */
    public function setAfbeelding($afbeelding){
        $this->afbeelding = $afbeelding;
        return $this;
    }
    /**
     * Get afbeelding
     * 
     * @return string
     */
    public function getAfbeelding(){
        return $this->afbeelding;
    }
    
    /**
     * Set skills
     * 
     * @param ArrayCollection $skills
     * @return Project
     */
    public function setSkills($skills){
        $this->skills = new ArrayCollection($skills);
        return $this;
    }
    /**
     * 
     * @return ArrayCollection
     */
    public function getSkills(){
        return $this->skills->toArray();
    }
    
    public function addSkill(skill $skill){
        if(!$this->skills->contains($skill)){
            $this->skills->add($skill);
            $skill->addProject($this);
        }
        return $this;
    }
    /** @ORM\PrePersist */
    public function setDatecreated(){
        $this->datecreated = new \DateTime('NOW');
    }
    /**
     * @return datetime
     */
    public function getDatumcreated(){
        return $this->datecreated;
    }
}
