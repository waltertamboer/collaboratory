<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\InputFilter;

use CollabApplication\Validator\AbstractUnique;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;

class RepositoryInputFilter extends InputFilter
{
    public function __construct(AbstractUnique $uniqueNameValidator)
    {
        $inputName = new Input();
        $inputName->setName('type');
        $inputName->setRequired(true);
        $this->add($inputName);

        $inputName = new Input();
        $inputName->setName('name');
        $inputName->setRequired(true);
        $inputName->getValidatorChain()->addValidator($uniqueNameValidator);
        $filters = $inputName->getFilterChain();
        $filters->attachByName('StringToLower');
        $filters->attachByName('PregReplace', array(
            'pattern' => '/[^a-z0-9-]+/i',
            'replacement' => ''
        ));
        $this->add($inputName);

        $inputName = new Input();
        $inputName->setName('description');
        $inputName->setRequired(false);
        $this->add($inputName);

        $inputName = new Input();
        $inputName->setName('teams');
        $inputName->setRequired(false);
        $this->add($inputName);
    }
}
