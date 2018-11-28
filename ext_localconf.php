<?php
defined('TYPO3_MODE') || die('Access denied.');

// load HTML2PDF Library
//require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('rkw_webcheck') . 'Classes/Libs/vendor/autoload.php');

// set logger
$GLOBALS['TYPO3_CONF_VARS']['LOG']['RKW']['RkwWebcheck']['writerConfiguration'] = array(

	// configuration for WARNING severity, including all
	// levels with higher severity (ERROR, CRITICAL, EMERGENCY)
	\TYPO3\CMS\Core\Log\LogLevel::DEBUG => array(
		// add a FileWriter
		'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
			// configuration for the writer
			'logFile' => 'typo3temp/logs/tx_rkwwebcheck.log'
		)
	),
);


call_user_func(
	function($extKey)
	{
		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
			'RKW.RkwWebcheck',
			'Check',
			[
				'Webcheck' => 'checkInit, checkStart, showQuestionResult, updateQuestionResult, showTopicResult, updateTopicResult, showCheckResult, updateCheckResult, shareCheckResult, error'
			],
			// non-cacheable actions
			[
				'Webcheck' => 'checkInit, checkStart, showQuestionResult, updateQuestionResult, showTopicResult, updateTopicResult, showCheckResult, updateCheckResult, shareCheckResult, error'
			]
		);

		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
			'RKW.RkwWebcheck',
			'Benchmark',
			[
				'Webcheck' => 'showBenchmark, error'
			],
			// non-cacheable actions
			[
				'Webcheck' => 'showBenchmark, error'
			]
		);

		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
			'RKW.RkwWebcheck',
			'SharedCheck',
			[
				'Webcheck' => 'showSharedCheckResult, error'
			],
			// non-cacheable actions
			[
				'Webcheck' => 'showSharedCheckResult, error'
			]
		);

		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
			'RKW.RkwWebcheck',
			'MyChecks',
			[
				'Webcheck' => 'showMyCheckResults, deleteCheckResult, editCheckResult, error'
			],
			// non-cacheable actions
			[
				'Webcheck' => 'showMyCheckResults, deleteCheckResult, editCheckResult, error'
			]
		);

		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
			'RKW.RkwWebcheck',
			'Feedback',
			[
				'Webcheck' => 'feedback, error'
			],
			// non-cacheable actions
			[
				'Webcheck' => 'feedback, error'
			]
		);

	},

	$_EXTKEY
);
