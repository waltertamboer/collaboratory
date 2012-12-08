<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplication\Service;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SassFilterFactory implements FactoryInterface, FilterInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this;
    }

    /**
     * Filters an asset after it has been loaded.
     *
     * @param AssetInterface $asset An asset
     */
    public function filterLoad(AssetInterface $asset)
    {
        $scssc = new \scssc();
        $scssc->setFormatter('scss_formatter_compressed');

        new \scss_compass($scssc);

        $asset->setContent($scssc->compile($asset->getContent()));
    }

    /**
     * Filters an asset just before it's dumped.
     *
     * @param AssetInterface $asset An asset
     */
    public function filterDump(AssetInterface $asset)
    {
    }
}
