<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabProject\Form;

use CollabProject\Entity\Project;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ProjectForm extends Form
{
    public function __construct()
    {
        parent::__construct('team');

        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setObject(new Project());

        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputName = new Input();
        $inputName->setName('name');
        $inputName->setRequired(true);
        $inputFilter->add($inputName);

        $inputName = new Input();
        $inputName->setName('description');
        $inputName->setRequired(true);
        $inputFilter->add($inputName);

        $name = new Text('name');
        $name->setLabel('Project name');
        $this->add($name);

        $description = new Textarea();
        $description->setName('description');
        $description->setLabel('Description');
        $this->add($description);

        $submitButton = new Submit();
        $submitButton->setName('save');
        $submitButton->setLabel('Save');
        $submitButton->setValue('Save');
        $this->add($submitButton);
    }
}
