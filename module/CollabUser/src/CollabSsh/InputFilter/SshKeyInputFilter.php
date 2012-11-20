<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabSsh\InputFilter;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;

class SshKeyInputFilter extends InputFilter
{
    public function __construct()
    {
        $identity = new Input();
        $identity->setName('name');
        $identity->setRequired(true);
        $this->add($identity);

        $teams = new Input();
        $teams->setName('content');
        $teams->setRequired(true);
        $this->add($teams);
    }
}
