<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\Form;

use CollabApplication\Validator\AbstractUnique;
use CollabScm\Entity\Repository;
use CollabScm\InputFilter\RepositoryInputFilter;
use Zend\Form\Element\Collection;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class RepositoryForm extends Form
{
    public function __construct(AbstractUnique $uniqueNameValidator)
    {
        parent::__construct('repository');

        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setObject(new Repository());
        $this->setInputFilter(new RepositoryInputFilter($uniqueNameValidator));

        $type = new Select('type');
        $type->setLabel('Type');
        $type->setEmptyOption('---');
        $type->setValueOptions(array(
            'git' => 'Git',
            'svn' => 'Subversion',
        ));
        $this->add($type);

        $name = new Text('name');
        $name->setLabel('Name');
        $this->add($name);

        $description = new Textarea();
        $description->setName('description');
        $description->setLabel('Description');
        $this->add($description);

        $teams = new Collection();
        $teams->setName('teams');
        $teams->setLabel('Teams');
        $teams->setAllowAdd(true);
        $teams->setShouldCreateTemplate(true);
        $teams->setTargetElement(array(
            'type' => 'CollabScm\Form\Fieldset\TeamFieldset'
        ));
        $this->add($teams);

        $submitButton = new Submit();
        $submitButton->setName('save');
        $submitButton->setLabel('Save');
        $submitButton->setValue('Save');
        $this->add($submitButton);
    }
}
