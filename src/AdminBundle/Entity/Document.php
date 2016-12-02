<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AdminBundle\Entity\File as BaseImage;

/**
 * Document
 *
 * @ORM\Table(name="document")
 * @ORM\Entity()
 */
class Document extends BaseImage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
	

    /**
     * @var string
     *
     * @Assert\File(maxSize = "6M", mimeTypes = {"image/jpeg", "image/gif", "image/png" , "image/jpg", "application/pdf" , "application/x-pdf"  } , mimeTypesMessage = "Le fichier choisi ne correspond pas à un fichier valide"  , notFoundMessage = "Le fichier n'a pas été trouvé sur le disque" , uploadErrorMessage = "Erreur dans l'upload du fichier" )
     */
    private $tempFile;

   

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tempFile
     *
     * @param string $tempFile
     *
     * @return File
     */
    public function setTempFile($tempFile)
    {
        $this->tempFile = $tempFile;

        if (null !== $this->url) {

            $this->tempFileName = $this->url;

            $this->url = null;
        }

        return $this;
    }

    /**
     * Get tempFile
     *
     * @return string
     */
    public function getTempFile()
    {
        return $this->tempFile;
    }

 
    public function getUploadDir()
    {
        return 'uploads/documents'; 
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        $absolutePath = $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();

        if(file_exists($absolutePath)) {
            return $absolutePath;
        }

        return $this->getUploadDir().'/no-image.png';
    }

 
}
