<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File
 *
 * @ORM\MappedSuperclass
 */
class File
{
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    protected $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255 )
     */
    protected $alt;

    /**
     * @var string
     */
    protected $tempFileName;



    /**
     * Set url
     *
     * @param string $url
     *
     * @return File
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return File
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set tempFileName
     *
     * @param string $tempFileName
     *
     * @return File
     */
    public function setTempFileName($tempFileName)
    {
        $this->tempFileName = $tempFileName;

        return $this;
    }

    /**
     * Get tempFileName
     *
     * @return string
     */
    public function getTempFileName()
    {
        return $this->tempFileName;
    }
}
