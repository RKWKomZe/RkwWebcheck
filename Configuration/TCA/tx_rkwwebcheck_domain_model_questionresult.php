<?php
return [
    'ctrl'      => [
        'hideTable'                => 1,
        'title'                    => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_questionresult',
        'label'                    => 'fe_user',
        'tstamp'                   => 'tstamp',
        'crdate'                   => 'crdate',
        'cruser_id'                => 'cruser_id',
        'delete'                   => 'deleted',
        'enablecolumns'            => [
        ],
        'searchFields'             => 'fe_user,sum,webcheck,question',
        'iconfile'                 => 'EXT:rkw_webcheck/Resources/Public/Icons/tx_rkwwebcheck_domain_model_questionresult.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'sum, webcheck, question',
    ],
    'types'     => [
        '1' => ['showitem' => 'sum, webcheck, question'],
    ],
    'columns'   => [

        'sum'              => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_questionresult.sum',
            'config'  => [
                'type'     => 'input',
                'size'     => 4,
                'readOnly' => 1,
                'eval'     => 'int',
            ],
        ],
        'webcheck'          => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_questionresult.webcheck',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_rkwwebcheck_domain_model_webcheck',
                'minitems'      => 1,
                'readOnly'      => 1,
                'maxitems'      => 1,
            ],
        ],
        'topic'         => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_questionresult.topic',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_rkwwebcheck_domain_model_topic',
                'minitems'      => 0,
                'readOnly'      => 1,
                'maxitems'      => 1,
            ],
        ],
        'question'         => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_questionresult.question',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_rkwwebcheck_domain_model_question',
                'minitems'      => 0,
                'readOnly'      => 1,
                'maxitems'      => 1,
            ],
        ],
        'topic_result'      => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
