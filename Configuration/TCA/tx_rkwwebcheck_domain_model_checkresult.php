<?php
return [
    'ctrl'      => [
        'hideTable'                => 1,
        'title'                    => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_checkresult',
        'label'                    => 'fe_user',
        'tstamp'                   => 'tstamp',
        'crdate'                   => 'crdate',
        'cruser_id'                => 'cruser_id',
        'delete'                   => 'deleted',
        'enablecolumns'            => [
        ],
        'searchFields'             => 'fe_user,sum,completed,send_notification,notification_timestamp,results,last_topic,last_question,webcheck',
        'iconfile'                 => 'EXT:rkw_webcheck/Resources/Public/Icons/tx_rkwwebcheck_domain_model_checkresult.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'fe_user, sum, percentage, completed, send_notification, notification_timestamp, results, last_topic, last_question, webcheck',
    ],
    'types'     => [
        '1' => ['showitem' => 'fe_user, sum, percentage,completed, send_notification, notification_timestamp, results, last_topic, last_question, webcheck'],
    ],
    'columns'   => [

        'fe_user'                => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_checkresult.fe_user',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'fe_users',
                'readOnly'      => 1,
                'maxitems'      => 1,
            ],
        ],
        'sum'                    => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_checkresult.sum',
            'config'  => [
                'type'     => 'input',
                'size'     => 4,
                'readOnly' => 1,
                'eval'     => 'int',
            ],
        ],
        'percentage'                    => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_checkresult.percentage',
            'config'  => [
                'type'     => 'input',
                'size'     => 4,
                'readOnly' => 1,
                'eval'     => 'float',
            ],
        ],
        'completed'              => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_checkresult.completed',
            'config'  => [
                'type'     => 'input',
                'size'     => 4,
                'readOnly' => 1,
                'eval'     => 'int',
            ],
        ],
        'send_notification'      => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_checkresult.send_notification',
            'config'  => [
                'type'     => 'check',
                'items'    => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled',
                    ],
                ],
                'readOnly' => 1,
                'default'  => 0,
            ],
        ],
        'notification_timestamp' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_checkresult.notification_timestamp',
            'config'  => [
                'type'     => 'input',
                'size'     => 4,
                'readOnly' => 1,
                'eval'     => 'int',
            ],
        ],
        'results'                => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_checkresult.results',
            'config'  => [
                'type'          => 'inline',
                'foreign_table' => 'tx_rkwwebcheck_domain_model_topicresult',
                'foreign_field' => 'check_result',
                'maxitems'      => 9999,
                'readOnly'      => 1,
                'appearance'    => [
                    'collapseAll'                     => 0,
                    'levelLinksPosition'              => 'top',
                    'showSynchronizationLink'         => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink'         => 1,
                ],
            ],
        ],
        'last_topic'             => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_checkresult.last_topic',
            'config'  => [
                'type'          => 'inline',
                'foreign_table' => 'tx_rkwwebcheck_domain_model_topic',
                'minitems'      => 0,
                'maxitems'      => 1,
                'readOnly'      => 1,
                'appearance'    => [
                    'collapseAll'                     => 0,
                    'levelLinksPosition'              => 'top',
                    'showSynchronizationLink'         => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink'         => 1,
                ],
            ],
        ],
        'last_question'          => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_checkresult.last_question',
            'config'  => [
                'type'          => 'inline',
                'foreign_table' => 'tx_rkwwebcheck_domain_model_question',
                'minitems'      => 0,
                'maxitems'      => 1,
                'readOnly'      => 1,
                'appearance'    => [
                    'collapseAll'                     => 0,
                    'levelLinksPosition'              => 'top',
                    'showSynchronizationLink'         => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink'         => 1,
                ],
            ],
        ],
        'webcheck'                => [
            'exclude' => true,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_checkresult.webcheck',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_rkwwebcheck_domain_model_webcheck',
                'readOnly'      => 1,
                'minitems'      => 0,
                'maxitems'      => 1,
            ],
        ],
    ],
];
