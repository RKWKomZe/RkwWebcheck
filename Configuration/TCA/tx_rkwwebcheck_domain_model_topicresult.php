<?php
return [
    'ctrl'      => [
        'hideTable'                => 1,
        'title'                    => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_topicresult',
        'label'                    => 'fe_user',
        'tstamp'                   => 'tstamp',
        'crdate'                   => 'crdate',
        'cruser_id'                => 'cruser_id',
        'delete'                   => 'deleted',
        'enablecolumns'            => [
        ],
        'searchFields'             => 'fe_user,sum,webcheck,topic,results',
        'iconfile'                 => 'EXT:rkw_webcheck/Resources/Public/Icons/tx_rkwwebcheck_domain_model_topicresult.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'sum, percentage, webcheck, topic, results',
    ],
    'types'     => [
        '1' => ['showitem' => 'sum, percentage, webcheck, topic, results'],
    ],
    'columns'   => [

        'sum'              => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_topicresult.sum',
            'config'  => [
                'type'     => 'input',
                'size'     => 4,
                'readOnly' => 1,
                'eval'     => 'int',
            ],
        ],
        'percentage'              => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_topicresult.percentage',
            'config'  => [
                'type'     => 'input',
                'size'     => 4,
                'readOnly' => 1,
                'eval'     => 'float',
            ],
        ],
        'webcheck'          => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_topicresult.webcheck',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_rkwwebcheck_domain_model_webcheck',
                'minitems'      => 1,
                'maxitems'      => 1,
                'readOnly'      => 1,
            ],
        ],
        'topic'            => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_topicresult.topic',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_rkwwebcheck_domain_model_topic',
                'minitems'      => 1,
                'maxitems'      => 1,
                'readOnly'      => 1,
            ],
        ],
        'results'          => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_topicresult.results',
            'config'  => [
                'type'          => 'inline',
                'foreign_table' => 'tx_rkwwebcheck_domain_model_questionresult',
                'foreign_field' => 'topic_result',
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
        'check_result'      => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
