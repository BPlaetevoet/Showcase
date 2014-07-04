<?php

namespace Bplaetevoet\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="skills")
 */
class Skill
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $naam;
    
    /**
     * @ORM\ManyToMany(targetEntity="Project", inversedBy="skills")
     */
    protected $project;
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $omschrijving;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $level;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set naam
     *
     * @param string $naam
     * @return Skill
     */
    public function setNaam($naam)
    {
        $this->naam = $naam;

        return $this;
    }

    /**
     * Get naam
     *
     * @return string 
     */
    public function getNaam()
    {
        return $this->naam;
    }
    /**
     * 
     * @param integer $project
     */
    public function setProject($project){
        $this->project = $project;
        return $this;
    }
    /**
     * 
     * @return ArrayCollection
     */
    public function getProject(){
        return $this->project;
    }
    
    public function addProject(project $project){
        if(!$this->project->contains($project)){
            $this->project->add($project);
        }
        return $this;
    }
    
    /**
     * Set omschrijving
     *
     * @param string $omschrijving
     * @return Skill
     */
    public function setOmschrijving($omschrijving)
    {
        $this->omschrijving = $omschrijving;

        return $this;
    }

    /**
     * Get omschrijving
     *
     * @return string 
     */
    public function getOmschrijving()
    {
        return $this->omschrijving;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Skill
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }
}