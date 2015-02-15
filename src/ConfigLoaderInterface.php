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
 * The ConfigLoaderInterface should be implemented by all classes that load the
 * configuration variables that will be used in a toggle.
 *
 * @author Dimitris Bozelos <dbozelos@gmail.com>
 */
interface ConfigLoaderInterface
{
    /**
     * Loads or retrieves the configuration variables and returns them so that
     * they can be used by the toggle. Possible implementations could be to
     * define the variables directly in the code, load them from a file, retrieve
     * them by an HTTP request to an external API or anything else.
     *
     * @return array|null $config An array containing the configuration variables or null if the configuration could not be loaded.
     */
    public function load();
}
