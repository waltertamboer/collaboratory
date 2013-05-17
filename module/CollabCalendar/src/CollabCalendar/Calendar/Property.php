<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendar\Calendar;

class Property
{
    private $name;
    private $value;
    private $param;

    public function __construct($name, $value, $param)
    {
        $this->name = $name;
        $this->value = $value;
        $this->param = $param;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getParam()
    {
        return $this->param;
    }
}
