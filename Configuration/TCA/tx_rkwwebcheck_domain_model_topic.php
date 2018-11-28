<?php
return [
    'ctrl'      => [
        'title'                    => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_topic',
        'label'                    => 'name',
        'tstamp'                   => 'tstamp',
        'crdate'                   => 'crdate',
        'cruser_id'                => 'cruser_id',
        'languageField'            => 'sys_language_uid',
        'transOrigPointerField'    => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete'                   => 'deleted',
        'enablecolumns'            => [
            'disabled' => 'hidden',
        ],
        'searchFields'             => 'name,description,weight,result_a,result_b,result_c,questions',
        'iconfile'                 => 'EXT:rkw_webcheck/Resources/Public/Icons/tx_rkwwebcheck_domain_model_topic.gif',
        'hideTable'                => true,
    ],
    'interface' => [
        // 'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, description, weight, result_a, result_b, result_c, questions',
        'showRecordFieldList' => 'hidden, name, description, weight, result_a, result_b, result_c, questions',
    ],
    'types'     => [
        // '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, description, weight, result_a, result_b, result_c, questions'],
        '1' => ['showitem' => 'hidden, name, description, weight, result_a, result_b, result_c, questions'],
    ],
    'columns'   => [
        /*
        'sys_language_uid' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config'  => [
                'type'       => 'select',
                'renderType' => 'selectSingle',
                'special'    => 'languages',
                'items'      => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple',
                    ],
                ],
                'default'    => 0,
            ],
        ],
        'l10n_parent'      => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude'     => true,
            'label'       => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config'      => [
                'type'                => 'select',
                'renderType'          => 'selectSingle',
                'items'               => [
                    ['', 0],
                ],
                'foreign_table'       => 'tx_rkwwebcheck_domain_model_topic',
                'foreign_table_where' => 'AND tx_rkwwebcheck_domain_model_topic.pid=###CURRENT_PID### AND tx_rkwwebcheck_domain_model_topic.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource'  => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        */
        'hidden'           => [
            'exclude' => true,
            'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config'  => [
                'type'  => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled',
                    ],
                ],
            ],
        ],
        'starttime'        => [
            'exclude'   => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label'     => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config'    => [
                'type'    => 'input',
                'size'    => 13,
                'eval'    => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime'          => [
            'exclude'   => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label'     => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config'    => [
                'type'    => 'input',
                'size'    => 13,
                'eval'    => 'datetime',
                'default' => 0,
                'range'   => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
            ],
        ],
        'name'             => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_topic.name',
            'config'  => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'description'      => [
            'exclude' => true,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_topic.description',
            'config'  => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'weight'           => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_topic.weight',
            'config'  => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2',
                'default' => '1.0',
            ],
        ],
        'result_a'         => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_topic.result_a',
            'config'  => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'result_b'         => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_topic.result_b',
            'config'  => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'result_c'         => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_topic.result_c',
            'config'  => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'questions'        => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_webcheck/Resources/Private/Language/locallang_db.xlf:tx_rkwwebcheck_domain_model_topic.questions',
            'config'  => [
                'type'          => 'inline',
                'foreign_table' => 'tx_rkwwebcheck_domain_model_question',
                'MM'            => 'tx_rkwwebcheck_topic_question_mm',
                'maxitems'      => 99,
                'minitems'      => 1,
                'appearance'    => [
                    'collapseAll'  => 1,
                    'expandSingle' => 1,
                ],
            ],
        ],
        'webcheck'          => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],

];
