<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabProject\Form;

use CollabProject\Entity\Project;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ProjectForm extends Form implements InputFilterProviderInterface
{
    private $serviceManager;

    public function __construct()
    {
        parent::__construct('team');

        $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new Project())
             ->setInputFilter(new InputFilter());

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

    public function getInputFilterSpecification()
    {
        return array(
            'name' => array(
                'required' => true,
            ),
            'description' => array(
                'required' => true,
            ),
        );
    }
}
