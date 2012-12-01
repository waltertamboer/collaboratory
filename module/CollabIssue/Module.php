<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabIssue;

use CollabIssue\Service\IssueService;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'CollabIssue\Service\IssueService' => function ($sl) {
                    $mapper = $sl->get('CollabIssue\Mapper\MapperInterface');

                    return new IssueService($mapper);
                },
            )
        );
    }
}
