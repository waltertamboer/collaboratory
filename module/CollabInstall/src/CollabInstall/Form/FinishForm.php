<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabInstall\Form;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class FinishForm extends Form
{
    public function __construct()
    {
        parent::__construct('database');

        $this->setAttribute('method', 'post');

        $element = new Submit('save');
        $element->setLabel('Save');
        $element->setValue('Save');
        $this->add($element);
    }
}
