<?php

namespace UserBundle\User;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use UserBundle\User\AbstractTrackingListener;
use UserBundle\User\Mapping\Event\UserAdapter;

/**
 * The User listener handles the update of
 * dates on creation and update.
 *
 * @author Traoré Donikan Lacina <tdonikanlacina@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class UserListener extends AbstractTrackingListener
{
    /**
     * @param ClassMetadata $meta
     * @param string $field
     * @param ContainerInterface $container
     * @param UserAdapter $eventAdapter
     * @return mixed
     */
    protected function getFieldValue($meta, $field, $container, $context, $eventAdapter)
    {
        return $eventAdapter->getUserValue($meta, $field, $container, $context);
    }

    /**
     * {@inheritDoc}
     */
    protected function getNamespace()
    {
        return __NAMESPACE__;
    }
}
