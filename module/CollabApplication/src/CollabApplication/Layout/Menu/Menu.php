<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplication\Layout\Menu;

use ArrayIterator;
use CollabApplication\Layout\Menu\MenuItem;
use IteratorAggregate;

class Menu implements IteratorAggregate
{
    private $childs;

    public function __construct()
    {
        $this->childs = array();
    }

    public function append(MenuItem $menuItem)
    {
        $this->childs[] = $menuItem;
    }

    public function insert($position, MenuItem $menuItem)
    {
        $this->childs[$position] = $menuItem;
        return $this;
    }

    public function getIterator()
    {
        ksort($this->childs);

        return new ArrayIterator($this->childs);
    }
}
