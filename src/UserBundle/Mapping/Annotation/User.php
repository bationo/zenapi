<?php

namespace UserBundle\Mapping\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * User annotation for User behavioral extension
 *
 * @Annotation
 * @Target("PROPERTY")
 *
 * @author traoré Donikan Lacina <tdonikanlacina@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
final class User extends Annotation
{
    /** @var string */
    public $on = 'update';
    /** @var string|array */
    public $field;
    /** @var mixed */
    public $value;
}
