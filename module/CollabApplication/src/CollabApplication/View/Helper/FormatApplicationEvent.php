<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplication\View\Helper;

use CollabApplication\Entity\ApplicationEvent;
use Zend\View\Helper\AbstractHelper;

class FormatApplicationEvent extends AbstractHelper
{
    public function __invoke(ApplicationEvent $event)
    {
        return $event->getCreationDate()->format('d-m-Y, H:i:s')
            . ' - ' . $event->getType()
            . ' - ' . print_r($event->getParameters(), true)
            . '<hr />';
    }
}
