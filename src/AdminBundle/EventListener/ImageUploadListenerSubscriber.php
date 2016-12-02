<?php
/**
 * Created by PhpStorm.
 * User: DONIKAN
 * Date: 01/07/2016
 * Time: 12:27
 */

namespace AdminBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AdminBundle\Entity\Image;

class ImageUploadListenerSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'postUpdate',
            'preRemove',
            'postRemove',
        );
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // perhaps you only want to act on some "User" entity
        if ($entity instanceof Image) {
            $entityManager = $args->getEntityManager();
            // ... do something with the User
        }
    }
}