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

use CollabApplication\Layout\LayoutManager;
use Zend\View\Helper\AbstractHelper;

class CollabMenu extends AbstractHelper
{
    private $layoutManager;

    public function __construct(LayoutManager $layoutManager)
    {
        $this->layoutManager = $layoutManager;
    }

    public function __invoke($name)
    {
        $menu = $this->layoutManager->getMenu($name);

        $output = '';
        $output .= '<ul>' . PHP_EOL;
        foreach ($menu as $item) {
            $link = $item->getLink();
            if ($link) {
                $output .= '<li><a href="' . $link . '" title="' . $item->getLabel() . '">' . $item->getLabel() . '</a></li>' . PHP_EOL;
            } else {
                $output .= '<li>' . $item->getLabel() . '</li>' . PHP_EOL;
            }
        }
        $output .= '</ul>' . PHP_EOL;

        return $output;
    }
}
