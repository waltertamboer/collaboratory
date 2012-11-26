<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class ScmPath extends AbstractPlugin
{
    public function __invoke()
    {
        $path = $this->getController()->params('path') ?: '/';
        $path = explode('/', $path);
        $path = array_filter($path);

        return '/' . implode('/', $path);
    }
}
