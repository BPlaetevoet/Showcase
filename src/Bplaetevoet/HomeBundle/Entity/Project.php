<?php
// src/Bplaetevoet/HomeBundle/Entity/Project.php
namespace Bplaetevoet\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var integer
     * 
     * @ORM\OneToMany(targetEntity="Afbeelding", mappedBy="project")
     * @ORM\JoinColumn(name="afbeelding_id", referencedColumnName="id")
     * 
     */
    protected $afbeeldingen;
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Skill")
     * @ORM\JoinTable(name="skill_project", joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")},
     *                                      inverseJoinColumns={@ORM\JoinColumn(name="skill_id", referencedColumnName="id")}
     * )
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
    public function setAfbeeldingen($afbeeldingen){
        $this->afbeeldingen = new ArrayCollection();
        return $this;
    }
    /**
     * 
     * @param \Bplaetevoet\HomeBundle\Entity\Afbeelding $afbeelding
     */
    public function addAfbeelding(Afbeelding $afbeelding){
         if(!$this->afbeeldingen->contains($afbeelding)){
            $this->afbeeldingen->add($afbeelding);
            $afbeelding->setProject($this);
            
        }
        return $this;
    }
    /**
     * Get afbeelding
     * 
     * @return string
     */
    public function getAfbeeldingen(){
        return $this->afbeeldingen;
    }
  
    /**
     * Set skills
     * 
     * @param ArrayCollection $skills
     * @return Project
     */
    public function setSkills($skills){
        $this->skills = new ArrayCollection();
        foreach($skills as $skill){
            $this->addSkill($skill);
        }
        return $this;
    }
    /**
     * 
     * @return ArrayCollection
     */
    public function getSkills(){
        return $this->skills;
    }
    /**
     * 
     * @param \Bplaetevoet\HomeBundle\Entity\skill $skill
     * @return \Bplaetevoet\HomeBundle\Entity\Project
     */
    public function addSkill(skill $skill){
        $this->skills->add($skill);
        
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
