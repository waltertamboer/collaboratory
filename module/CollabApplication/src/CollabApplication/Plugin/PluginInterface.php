<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplication\Plugin;

/**
 * The interface that all plugins should implement.
 */
interface PluginInterface
{
    /**
     * Gets the name of the plugin.
     *
     * @return string
     */
    public function getName();

    /**
     * Gets the version of the plugin.
     *
     * @return string
     */
    public function getVersion();
}
