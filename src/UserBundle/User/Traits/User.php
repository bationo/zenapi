<?php

namespace UserBundle\User\Traits;

/**
 * User Trait, usable with PHP >= 5.4
 *
 * @author Traoré Donikan Lacina <tdonikanlacina@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
trait User
{
    /**
     * @var \UserBundle\Entity\User
     */
    protected $createdBy;

    /**
     * @var \UserBundle\Entity\User
     */
    protected $updatedBy;

    /**
     * Sets createdBy.
     *
     * @param  \UserBundle\Entity\User $createdBy
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
     * @return \UserBundle\Entity\User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
}
