<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplication\Layout;

use CollabApplication\Layout\Menu\Menu;
use Zend\EventManager\EventManager;
use Zend\View\Renderer\RendererInterface;

class LayoutManager
{
    private $eventManager;
    private $menus;
    private $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->menus = array();
        $this->renderer = $renderer;
    }

    public function getEventManager()
    {
        if (!$this->eventManager) {
            $this->eventManager = new EventManager('CollabLayout');
        }
        return $this->eventManager;
    }

    public function getMenu($name)
    {
        if (!array_key_exists($name, $this->menus)) {
            $this->menus[$name] = new Menu();

            $eventArg = array('name' => $name);
            $this->getEventManager()->trigger('initializeMenu', $this, $eventArg);
        }
        return $this->menus[$name];
    }

    public function getRenderer()
    {
        return $this->renderer;
    }
}
