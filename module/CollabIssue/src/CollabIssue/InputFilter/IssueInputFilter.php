<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabIssue\InputFilter;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;

class IssueInputFilter extends InputFilter
{
    public function __construct()
    {
        $title = new Input();
        $title->setName('title');
        $title->setRequired(true);
        $this->add($title);

        $description = new Input();
        $description->setName('description');
        $description->setRequired(true);
        $this->add($description);
    }
}
