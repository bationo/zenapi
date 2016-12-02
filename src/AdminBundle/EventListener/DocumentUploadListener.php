<?php
/**
 * Created by PhpStorm.
 * User: DONIKAN
 * Date: 30/06/2016
 * Time: 11:44
 */

namespace AdminBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AdminBundle\Entity\Document;
use AdminBundle\Uploader\FileUploader;

class DocumentUploadListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->preUploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->preUploadFile($entity);
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Document) {
            return;
        }

        $entity->setTempFileName($this->uploader->getTargetDir().'/'.$entity->getId().'.'.$entity->getUrl());
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->postUploadFile($entity);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->postUploadFile($entity);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Document) {
            return;
        }

        if (file_exists($entity->getTempFileName())) {
            unlink($entity->getTempFileName());
        }
    }

    private function preUploadFile($entity)
    {
        if (!$entity instanceof Document) {
            return;
        }

        $file = $entity->getTempFile();

        if (!$file instanceof UploadedFile) {
            return;
        }

        if (null === $file) {
            return;
        }

        $entity->setUrl($file->guessExtension());
        $entity->setAlt($file->getClientOriginalName());
    }

    private function postUploadFile($entity)
    {
        // upload only works for Document entities
        if (!$entity instanceof Document) {
            return;
        }

        $file = $entity->getTempFile();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        if (null === $file) {
            return;
        }

        if (null !== $entity->getTempFilename()) {
            $oldFile = $this->uploader->getTargetDir().'/'.$entity->getId().'.'.$entity->getTempFilename();

            if(file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $fileName = $entity->getId().'.'.$entity->getUrl();

        $this->uploader->upload($file, $fileName);
    }
}