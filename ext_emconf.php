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
    'author' => 'Maximilian Fäßler, Steffen Kroggel, Philipp Grigoleit, Salih Özdemir',
    'author_email' => 'maximilian@faesslerweb.de, developer@steffenkroggel.de, p.grigoleit@agentur-fahrenheit.de, s.oezdemir@agentur-fahrenheit.de',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '7.6.9',
    'constraints' => [
        'depends' => [
            'extbase' => '6.2.0-7.6.99',
            'fluid' => '6.2.0-7.6.99',
            'typo3' => '6.2.0-7.6.99',
			'rkw_basics' => '7.6.10-7.6.99',
			'rkw_mailer' => '7.6.10-7.6.99',
			'rkw_registration' => '7.6.10-7.6.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' =>
        array(
            'classmap' => array('Classes')
        ),
];
