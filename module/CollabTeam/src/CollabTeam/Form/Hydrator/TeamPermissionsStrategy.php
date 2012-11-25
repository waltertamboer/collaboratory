<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabTeam\Form\Hydrator;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class TeamPermissionsStrategy implements StrategyInterface
{
    private $permissionsService;

    public function __construct($permissionsService)
    {
        $this->permissionsService = $permissionsService;
    }

    public function extract($value)
    {
        return $value;
    }

    public function hydrate($value)
    {
        $result = $value;
        if (is_array($value)) {
            $result = array();
            foreach ($value as $entity) {
                $result[] = $this->permissionsService->find($entity);
            }
        }
        return $result;
    }
}
