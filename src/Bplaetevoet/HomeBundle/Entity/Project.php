<?php
// src/Bplaetevoet/HomeBundle/Entity/Project.php
namespace Bplaetevoet\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\ExecutionContextInterface;



/**
 * Project
 * @ORM\HasLifecycleCallbacks() 
 * @ORM\Entity(repositoryClass="Bplaetevoet\HomeBundle\Entity\ProjectRepository")
 * @ORM\Table(name="projects")
 * @Assert\Callback(methods={"isAfbeeldingUploadedOrExists"})
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
     * @ORM\Column(name="afbeelding", type="string", length=255)
     * 
     */
    protected $afbeelding;
    /**
     * Image file
     * 
     * @var File
     * 
     * @Assert\File(
     *          maxSize="2M",
     *          mimeTypes = {"image/jpeg"},
     *          maxSizeMessage = "Afbeeldingen mogen maximum 2MB groot zijn.",
     *          mimeTypesMessage = "Enkel jpg bestanden zijn toegelaten."
     * )
     */
    protected $file;
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
     * Voor het opslaan van de afbeelding
     * 
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload(){
        if (null !== $this->file){
//            $filename= sha1(uniqid(mt_rand(), true));
//            $this->path = $filename.'.'.$this->file->getExtension();
            $filename = $this->file->getClientOriginalName();
            $this->afbeelding = $filename;
        }
    }
    /**
     * Voor het verwijderen van de afbeelding
     * 
     * @ORM\PreRemove()
     */
    public function removeUpload(){
        if($file = $this->getAbsolutePath()){
            unlink($file);
        }
        
    }
    public function removeFile($file){
        $file_path = $this->getUploadRootDir().'/'.$file;
        if(file_exists($file_path)) unlink($file_path);
    }
    /**
     * Opslaan van de upload na persist
     * 
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(){
        if(null === $this->file){
            return;
        }
        $this->file->move(
                $this->getUploadRootDir(),
                $this->afbeelding
                );
        
        $this->file = null;
    }
    public function getAbsolutePath()
    {
        return null === $this->afbeelding
            ? null
            : $this->getUploadRootDir().'/'.$this->afbeelding;
    }
    public function getWebPath()
    {
        return null === $this->afbeelding
            ? null
            : $this->getUploadDir().'/'.$this->afbeelding;
    }
     protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/afbeeldingen';
    }
    /**
     * Sets file
     * 
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null){
        $this->file = $file;
    }
    /** 
     * Get file
     * 
     * @return UploadedFile
     */
    public function getFile(){
        return $this->file;
    }
   
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
    public function isAfbeeldingUploadedOrExists(ExecutionContextInterface $context){
        if(null === $this->afbeelding && null === $this->file){
            $context->addViolationAt('file', 'Gelieve een afbeelding te kiezen', array(), null);
        }
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
