<?php

namespace UserBundle\User;

/**
 * This interface is not necessary but can be implemented for
 * Entities which in some cases needs to be identified as
 * User
 *
 * @author Traoré Donikan Lacina <tdonikanlacina@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
interface User
{
    // user expects annotations on properties

    /**
     * @user:User(on="create")
     * dates which should be updated on insert only
     */

    /**
     * @user:User(on="update")
     * dates which should be updated on update and insert
     */

    /**
     * @user:User(on="change", field="field", value="value")
     * dates which should be updated on changed "property"
     * value and become equal to given "value"
     */

    /**
     * @user:User(on="change", field="field")
     * dates which should be updated on changed "property"
     */

    /**
     * @user:User(on="change", fields={"field1", "field2"})
     * dates which should be updated if at least one of the given fields changed
     */

    /**
     * example
     *
     * @user:User(on="create")
     * @Column(type="date")
     * $created
     */
}
