<?php

namespace UserBundle\User\Mapping\Driver;

use Gedmo\Mapping\Driver\AbstractAnnotationDriver;
use Gedmo\Exception\InvalidMappingException;

/**
 * This is an annotation mapping driver for User
 * behavioral extension. Used for extraction of extended
 * metadata from Annotations specifically for User
 * extension.
 *
 * @author Traoré Donikan Lacina <tdonikanlacina@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class Annotation extends AbstractAnnotationDriver
{
    /**
     * Annotation field is user
     */
    const USER = 'UserBundle\\Mapping\\Annotation\\User';

    /**
     * List of types which are valid for timestamp
     *
     * @var array
     */
    /*protected $validTypes = array(
        'date',
        'time',
        'datetime',
        'datetimetz',
        'timestamp',
        'zenddate',
        'vardatetime',
        'integer',
    );*/

    /**
     * {@inheritDoc}
     */
    public function readExtendedMetadata($meta, array &$config)
    {
        $class = $this->getMetaReflectionClass($meta);
        // property annotations
        foreach ($class->getProperties() as $property) {
            if ($meta->isMappedSuperclass && !$property->isPrivate() ||
                $meta->isInheritedField($property->name) ||
                isset($meta->associationMappings[$property->name]['inherited'])
            ) {
                continue;
            }
            if ($user = $this->reader->getPropertyAnnotation($property, self::USER)) {
                $field = $property->getName();
                /*if (!$meta->hasField($field)) {
                    throw new InvalidMappingException("Unable to find user [{$field}] as mapped property in entity - {$meta->name}");
                }
                if (!$this->isValidField($meta, $field)) {
                    throw new InvalidMappingException("Field - [{$field}] type is not valid and must be 'date', 'datetime' or 'time' in class - {$meta->name}");
                }*/
                if (!in_array($user->on, array('update', 'create'))) {
                    throw new InvalidMappingException("Field - [{$field}] trigger 'on' is not one of [update, create] in class - {$meta->name}");
                }
                // properties are unique and mapper checks that, no risk here
                $config[$user->on][] = $field;
            }
        }
    }
}
