<?php
declare(strict_types = 1);

return [
    \RKW\RkwWebcheck\Domain\Model\FrontendUser::class => [
        'tableName' => 'fe_users',
    ],
    \RKW\RkwWebcheck\Domain\Model\BackendUser::class => [
        'tableName' => 'be_users',
        'properties' => [
            'backendUserGroups' => [
                'fieldName' => 'usergroup'
            ],
        ],
    ],
    \RKW\RkwWebcheck\Domain\Model\CheckResult::class => [
        'properties' => [
            'tstamp' => [
                'fieldName' => 'tstamp'
            ],
            'crdate' => [
                'fieldName' => 'crdate'
            ],
        ],
    ],
];
