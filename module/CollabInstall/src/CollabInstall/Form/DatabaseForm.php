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
use Zend\Stdlib\Hydrator\ArraySerializable;

class DatabaseForm extends Form
{
    public function __construct()
    {
        parent::__construct('database');

        $this->setAttribute('method', 'post');
        $this->setHydrator(new ArraySerializable());

        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputName = new Input();
        $inputName->setName('host');
        $inputName->setRequired(true);
        $inputFilter->add($inputName);

        $inputName = new Input();
        $inputName->setName('port');
        $inputName->setRequired(true);
        $inputFilter->add($inputName);

        $inputName = new Input();
        $inputName->setName('username');
        $inputName->setRequired(true);
        $inputFilter->add($inputName);

        $inputName = new Input();
        $inputName->setName('password');
        $inputName->setRequired(true);
        $inputFilter->add($inputName);

        $inputName = new Input();
        $inputName->setName('dbname');
        $inputName->setRequired(true);
        $inputFilter->add($inputName);

        $element = new Text('host');
        $element->setLabel('Host');
        $this->add($element);

        $element = new Text('port');
        $element->setLabel('Port');
        $this->add($element);

        $element = new Text('username');
        $element->setLabel('Username');
        $this->add($element);

        $element = new Text('password');
        $element->setLabel('Password');
        $this->add($element);

        $element = new Text('dbname');
        $element->setLabel('Database');
        $this->add($element);

        $element = new Submit('save');
        $element->setLabel('Save');
        $element->setValue('Save');
        $this->add($element);
    }
}
