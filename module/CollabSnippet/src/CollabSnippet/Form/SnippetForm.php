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
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class SnippetForm extends Form
{
    public function __construct()
    {
        parent::__construct('snippet');

        $this->setAttribute('method', 'post')
            ->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Snippet());

        $name = new Text('name');
        $name->setLabel('Name');
        $this->add($name);

        $description = new Textarea();
        $description->setName('description');
        $description->setLabel('Description');
        $this->add($description);

        $syntax = new Text('syntax');
        $syntax->setLabel('Syntax');
        $this->add($syntax);

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
