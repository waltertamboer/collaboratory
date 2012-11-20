<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabSnippet\Form;

use CollabSnippet\Entity\Snippet;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class SnippetForm extends Form
{
    public function __construct()
    {
        parent::__construct('snippet');

        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setObject(new Snippet());

        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $input = new Input();
        $input->setName('name');
        $input->setRequired(true);
        $inputFilter->add($input);

        $name = new Text('name');
        $name->setLabel('Name');
        $this->add($name);

        $input = new Input();
        $input->setName('description');
        $input->setRequired(false);
        $inputFilter->add($input);

        $description = new Textarea();
        $description->setName('description');
        $description->setLabel('Description');
        $this->add($description);

        $input = new Input();
        $input->setName('syntax');
        $input->setRequired(true);
        $inputFilter->add($input);

        $syntax = new Text('syntax');
        $syntax->setLabel('Syntax');
        $this->add($syntax);

        $input = new Input();
        $input->setName('content');
        $input->setRequired(true);
        $inputFilter->add($input);

        $content = new Textarea();
        $content->setName('content');
        $content->setLabel('Content');
        $this->add($content);

        $submitButton = new Submit();
        $submitButton->setName('save');
        $submitButton->setLabel('Save');
        $submitButton->setValue('Save');
        $this->add($submitButton);
    }

}
