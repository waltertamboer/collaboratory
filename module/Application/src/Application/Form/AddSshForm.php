<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace Application\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class AddSshForm extends Form
{
    public function __construct()
    {
        parent::__construct('addSsh');

        $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false));

        $name = new Text('name');
        $name->setLabel('Name');
        $this->add($name);

        $key = new Textarea('key');
        $key->setLabel('Key');
        $this->add($key);

        $submitButton = new Submit();
        $submitButton->setName('save');
        $submitButton->setLabel('Save');
        $submitButton->setValue('Save');
        $this->add($submitButton);
    }
}
