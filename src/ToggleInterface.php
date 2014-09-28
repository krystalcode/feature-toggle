<?php

/**
 * This file is part of the FeatureToggle package.
 *
 * (c) Dimitris Bozelos <dbozelos@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrystalCode\FeatureToggle;

/**
 * The ToggleInterface should be implemented by all toggle classes.
 *
 * @author Dimitris Bozelos <dbozelos@gmail.com>
 */
interface ToggleInterface
{
    /**
     * Returns the result of the case evaluation that determines whether the
     * feature should be included or not (feature on or off).
     *
     * @return boolean The result of the case evaluation.
     */
    public function on();
}
