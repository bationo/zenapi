<?php

namespace UserBundle\User\Mapping\Event\Adapter;

use Gedmo\Mapping\Event\Adapter\ODM as BaseAdapterODM;
use UserBundle\User\Mapping\Event\UserAdapter;

/**
 * Doctrine event adapter for ODM adapted
 * for User behavior
 *
 * @author Traoré Donikan Lacina <tdonikanlacina@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
final class ODM extends BaseAdapterODM implements UserAdapter
{
    /**
     * {@inheritDoc}
     */
    public function getUserValue($meta, $field, $container, $context)
    {
        return $context->getToken()->getUser();
    }
}
