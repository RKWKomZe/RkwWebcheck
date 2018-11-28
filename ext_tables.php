<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'RKW.RkwWebcheck',
    'Check',
    'RKW Webcheck: Check'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'RKW.RkwWebcheck',
    'SharedCheck',
    'RKW Webcheck: Shared Check'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'RKW.RkwWebcheck',
    'Benchmark',
    'RKW Webcheck: Benchmark'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'RKW.RkwWebcheck',
    'MyChecks',
    'RKW Webcheck: Meine Checks'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'RKW.RkwWebcheck',
    'Feedback',
    'RKW Webcheck: Feedback'
);

if (TYPO3_MODE === 'BE') {

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'RKW.RkwWebcheck',
        'web', // Make module a submodule of 'tools'
        'webcheckbe', // Submodule key
        '', // Position
        [
            'Backend' => 'list, result, print, pdf',
        ],
        [
            'access' => 'user,group',
            'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_webcheckbe.xlf',
        ]
    );

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'RKW Webcheck');

/*
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwwebcheck_domain_model_webcheck', 'EXT:rkw_webcheck/Resources/Private/Language/locallang_csh_tx_rkwwebcheck_domain_model_webcheck.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwwebcheck_domain_model_webcheck');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwwebcheck_domain_model_topic', 'EXT:rkw_webcheck/Resources/Private/Language/locallang_csh_tx_rkwwebcheck_domain_model_topic.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwwebcheck_domain_model_topic');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwwebcheck_domain_model_question', 'EXT:rkw_webcheck/Resources/Private/Language/locallang_csh_tx_rkwwebcheck_domain_model_question.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwwebcheck_domain_model_question');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwwebcheck_domain_model_checkresult', 'EXT:rkw_webcheck/Resources/Private/Language/locallang_csh_tx_rkwwebcheck_domain_model_checkresult.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwwebcheck_domain_model_checkresult');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwwebcheck_domain_model_topicresult', 'EXT:rkw_webcheck/Resources/Private/Language/locallang_csh_tx_rkwwebcheck_domain_model_topicresult.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwwebcheck_domain_model_topicresult');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwwebcheck_domain_model_questionresult', 'EXT:rkw_webcheck/Resources/Private/Language/locallang_csh_tx_rkwwebcheck_domain_model_questionresult.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwwebcheck_domain_model_questionresult');
*/

$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY));


$pluginName1 = strtolower('Check');
$pluginSignature1 = $extensionName.'_'.$pluginName1;

$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature1] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature1,
    'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/flexform_check.xml'
);

$pluginName2 = strtolower('Benchmark');
$pluginSignature2 = $extensionName.'_'.$pluginName2;

$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature2] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature2,
    'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/flexform_benchmark.xml'
);

/*
$pluginName3 = strtolower('ShareCheck');
$pluginSignature3 = $extensionName.'_'.$pluginName3;

$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature3] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature3,
    'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/flexform_share.xml'
);
*/

$pluginName5 = strtolower('SharedCheck');
$pluginSignature5 = $extensionName.'_'.$pluginName5;

$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature5] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature5,
    'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/flexform_shared.xml'
);


$pluginName4 = strtolower('MyChecks');
$pluginSignature4 = $extensionName.'_'.$pluginName4;

$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature4] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature4,
    'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/flexform_mychecks.xml'
);

$pluginName5 = strtolower('Feedback');
$pluginSignature5 = $extensionName.'_'.$pluginName5;

$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature5] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature5,
    'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/flexform_feedback.xml'
);