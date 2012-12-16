<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Address extends AbstractHelper
{
    public function __invoke($repository)
    {
        $result = '';

        if ($repository->getType() == 'svn') {
            $result = '';
        } else {
            $result .= 'git@';
            $result .= $_SERVER['SERVER_ADDR'];
            $result .= ':/';
            $result .= strtolower(preg_replace('/[^a-z0-9-]+/i', '', $repository->getProject()->getName()));
            $result .= '/';
            $result .= strtolower(preg_replace('/[^a-z0-9-]+/i', '', $repository->getName()));
        }

        return $result;
    }
}
