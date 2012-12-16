<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabTeam\InputFilter;

use Zend\InputFilter\InputFilter;

class TeamInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'name',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'description',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'members',
            'required' => false,
        ));

        $this->add(array(
            'name' => 'projects',
            'required' => false,
        ));

        $this->add(array(
            'name' => 'permission',
            'required' => false,
        ));
    }
}
