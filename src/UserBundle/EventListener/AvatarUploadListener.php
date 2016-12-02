<?php
/**
 * Created by PhpStorm.
 * User: DONIKAN
 * Date: 30/06/2016
 * Time: 11:44
 */

namespace UserBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use UserBundle\Entity\User;
use AdminBundle\Uploader\FileUploader;

class AvatarUploadListener
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

        if (!$entity instanceof User) {
            return;
        }

        $entity->setTempFileName($this->uploader->getTargetDir().'/'.$entity->getId().'.'.$entity->getAvatar());
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

        if (!$entity instanceof User) {
            return;
        }

        if (file_exists($entity->getTempFileName())) {
            unlink($entity->getTempFileName());
        }
    }

    private function preUploadFile($entity)
    {
        if (!$entity instanceof User) {
            return;
        }

        $file = $entity->getTempFile();

        if (!$file instanceof UploadedFile) {
            return;
        }

        if (null === $file) {
            return;
        }

        $entity->setAvatar($file->guessExtension());
    }

    private function postUploadFile($entity)
    {
        // upload only works for User entities
        if (!$entity instanceof User) {
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

        $fileName = $entity->getId().'.'.$entity->getAvatar();

        $this->uploader->upload($file, $fileName);
    }
}