<?php

namespace UserBundle\Mapping;

use Gedmo\Mapping\MappedEventSubscriber as BaseEventSubsbsriber;

/**
 * This is extension of event subscriber class and is
 * used specifically for handling the extension metadata
 * mapping for extensions.
 *
 * It dries up some reusable code which is common for
 * all extensions who maps additional metadata through
 * extended drivers
 *
 * @author Traoré Donikan Lacina <tdonikanlacina@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
abstract class MappedEventSubscriber extends BaseEventSubsbsriber
{
    /**
     * Custom container
     *
     * @var object
     */
    private $container;

    /**
     * Security context
     *
     * @var object
     */
    private $context;

    /**
     *
     * @param ContainerInterface $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }

    /**
     *
     * @param SecurityContext $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    public function getContext()
    {
        return $this->context;
    }

}
