<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "rkw_webcheck"
 *
 * Auto generated by Extension Builder 2017-08-17
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'RKW Webcheck',
    'description' => 'Der RKW Webseiten-Check, die Extension!',
    'category' => 'plugin',
    'author' => 'Maximilian Fäßler, Steffen Kroggel',
    'author_email' => 'maximilian@faesslerweb.de, developer@steffenkroggel.de',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'clearCacheOnLoad' => 0,
    'version' => '9.5.12',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.99',
            'rte_ckeditor' => '9.5.0-10.4.99',
            'core_extended' => '9.5.4-10.4.99',
			'postmaster' => '9.5.0-10.4.99',
			'fe_register' => '9.5.0-10.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' =>
        array(
            'classmap' => array('Classes')
        ),
];
