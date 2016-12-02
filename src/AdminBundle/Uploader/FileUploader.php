<?php
/**
 * Created by PhpStorm.
 * User: DONIKAN
 * Date: 30/06/2016
 * Time: 11:36
 */

namespace AdminBundle\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }

    public function upload(UploadedFile $file, $fileName = null)
    {
        if (null === $fileName) $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->targetDir, $fileName);

        return $fileName;
    }
}