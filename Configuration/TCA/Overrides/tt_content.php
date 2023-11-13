<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {
        //=================================================================
        // Register Plugin
        //=================================================================
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Check',
            'RKW Webcheck: Check'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'SharedCheck',
            'RKW Webcheck: Shared Check'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Benchmark',
            'RKW Webcheck: Benchmark'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'MyChecks',
            'RKW Webcheck: Meine Checks'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Feedback',
            'RKW Webcheck: Feedback'
        );

        //=================================================================
        // Add Flexforms
        //=================================================================
        $extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extKey));
        $pluginName1 = strtolower('Check');
        $pluginSignature1 = $extensionName.'_'.$pluginName1;

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature1] = 'pi_flexform';

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature1,
            'FILE:EXT:'.$extKey.'/Configuration/FlexForms/flexform_check.xml'
        );

        $pluginName2 = strtolower('Benchmark');
        $pluginSignature2 = $extensionName.'_'.$pluginName2;

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature2] = 'pi_flexform';

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature2,
            'FILE:EXT:'.$extKey.'/Configuration/FlexForms/flexform_benchmark.xml'
        );

        /*
        $pluginName3 = strtolower('ShareCheck');
        $pluginSignature3 = $extensionName.'_'.$pluginName3;

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature3] = 'pi_flexform';

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature3,
            'FILE:EXT:'.$extKey.'/Configuration/FlexForms/flexform_share.xml'
        );
        */

        $pluginName5 = strtolower('SharedCheck');
        $pluginSignature5 = $extensionName.'_'.$pluginName5;

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature5] = 'pi_flexform';

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature5,
            'FILE:EXT:'.$extKey.'/Configuration/FlexForms/flexform_shared.xml'
        );


        $pluginName4 = strtolower('MyChecks');
        $pluginSignature4 = $extensionName.'_'.$pluginName4;

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature4] = 'pi_flexform';

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature4,
            'FILE:EXT:'.$extKey.'/Configuration/FlexForms/flexform_mychecks.xml'
        );

        $pluginName5 = strtolower('Feedback');
        $pluginSignature5 = $extensionName.'_'.$pluginName5;

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature5] = 'pi_flexform';

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature5,
            'FILE:EXT:'.$extKey.'/Configuration/FlexForms/flexform_feedback.xml'
        );

    },
    'rkw_webcheck'
);
