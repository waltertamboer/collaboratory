<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplication\Validator;

use Zend\Validator\AbstractValidator;

abstract class AbstractUnique extends AbstractValidator
{
    const ERROR_OBJECT_FOUND = 'entityExists';

    protected $messageTemplates = array(
        self::ERROR_OBJECT_FOUND => "The entity '%value%' already exists",
    );

    private $exceptValues = array();

    public function __construct()
    {
        parent::__construct();
        $this->exceptValues = array();
    }

    public function addException($value)
    {
        $this->exceptValues[] = $value;
    }

    public function getExceptions()
    {
        return $this->exceptValues;
    }

    public abstract function checkValue($value);

    public function isValid($value)
    {
        $result = $this->checkValue($value);

        if (!$result) {
            $this->error(self::ERROR_OBJECT_FOUND, $value);
        }

        return $result;
    }

}
