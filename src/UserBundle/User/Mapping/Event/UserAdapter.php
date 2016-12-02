<?php

namespace UserBundle\User\Mapping\Event;

use Gedmo\Mapping\Event\AdapterInterface;

/**
 * Doctrine event adapter interface
 * for User behavior
 *
 * @author Traoré Donikan Lacina <tdonikanlacina@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
interface UserAdapter extends AdapterInterface
{
    /**
     * Get the date value
     *
     * @param object $meta
     * @param string $field
     * @param object $container
     *
     * @return mixed
     */
    public function getUserValue($meta, $field, $container, $context);
}
