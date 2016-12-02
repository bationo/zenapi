<?php

namespace UserBundle\User\Mapping\Event\Adapter;

use Gedmo\Mapping\Event\Adapter\ORM as BaseAdapterORM;
use UserBundle\User\Mapping\Event\UserAdapter;

/**
 * Doctrine event adapter for ORM adapted
 * for User behavior
 *
 * @author Traoré Donikan Lacina <tdonikanlacina@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
final class ORM extends BaseAdapterORM implements UserAdapter
{
    /**
     * {@inheritDoc}
     */
    public function getUserValue($meta, $field, $container, $context)
    {
        return $context->getToken()->getUser();
    }
}
