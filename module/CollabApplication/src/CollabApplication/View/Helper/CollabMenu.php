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
use Zend\View\Helper\AbstractHtmlElement;

class CollabMenu extends AbstractHtmlElement
{
    private $layoutManager;

    public function __construct(LayoutManager $layoutManager)
    {
        $this->layoutManager = $layoutManager;
    }

    public function __invoke($name, array $options = array())
    {
        $menu = $this->layoutManager->getMenu($name);

        $divided = array_key_exists('divided', $options) && $options['divided'] == true;

        $output = '<ul>' . PHP_EOL;
        foreach ($menu as $item) {
			
			$label = $item->getLabel();
			
			if ($item->getImage()) {
				$label = '<img src="' . $item->getImage() . '" alt="" /> ' . $label;
			}
			
            if ($item->getLink()) {
                $output .= '<li><a href="' . $item->getLink() . '">' . $label . '</a></li>' . PHP_EOL;
            } else {
                $output .= '<li>' . $label . '</li>' . PHP_EOL;
            }

            if ($divided) {
                $output .= '<li class="divider"></li>';
            }
        }
        $output .= '</ul>' . PHP_EOL;

        return $output;
    }
}
