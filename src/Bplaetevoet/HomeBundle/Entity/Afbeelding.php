<?php
// src/Bplaetevoet/HomeBundle/Entity/Afbeelding.php
namespace Bplaetevoet\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\HaslifecycleCallbacks
 * @ORM\Table(name="afbeeldingen")
 */
class Afbeelding{
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
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $path;
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
     * @var integer
     * 
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="afbeeldingen")
     */
    protected $project;
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
            $this->path = $filename;
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
                $this->path
                );
        
        $this->file = null;
    }
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }
    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
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
     * 
     * @param type $naam
     * @return Afbeelding
     */
    public function setNaam($naam){
        $this->naam = $naam;
        return $this;
    }
    /**
     * 
     * @return string
     */
    public function getNaam(){
        return $this->naam;
    }
    /**
     * 
     * @param type $project
     * @return \Bplaetevoet\HomeBundle\Entity\Afbeelding
     */
    public function setProject($project){
        $this->project = $project;
        return $this;
    }
    /**
     * 
     * @return type
     */
    public function getProject(){
        return $this->project;
    }
}

