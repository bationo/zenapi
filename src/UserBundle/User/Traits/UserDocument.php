<?php

namespace UserBundle\User\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use UserBundle\Mapping\Annotation as User;

/**
 * User Trait, usable with PHP >= 5.4
 *
 * @author Traoré Donikan Lacina <tdonikanlacina@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
trait UserDocument
{
    /**
     * @var \UserBundle\Entity\User
     * @User\User(on="create")
     * @ODM\String
     */
    protected $createdBy;

    /**
     * @var \UserBundle\Entity\User
     * @User\User(on="update")
     * @ODM\String
     */
    protected $updatedBy;

    /**
     * Sets createdBy.
     *
     * @param  \Datetime $createdBy
     * @return $this
     */
    public function setCreatedBy(\UserBundle\Entity\User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Returns createdBy.
     *
     * @return \UserBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Sets updatedBy.
     *
     * @param  \UserBundle\Entity\User $updatedBy
     * @return $this
     */
    public function setUpdatedBy(\UserBundle\Entity\User $updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Returns updatedBy.
     *
     * @return \Datetime
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
}
