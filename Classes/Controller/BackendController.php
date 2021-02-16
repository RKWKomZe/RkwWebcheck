<?php

namespace RKW\RkwWebcheck\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use \RKW\RkwBasics\Helper\Common;
use RKW\RkwWebcheck\Domain\Model\Webcheck;
use RKW\RkwWebcheck\Domain\Model\CheckResult;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class BackendController
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Philipp Grigoleit <p.grigoleit@agentur-fahrenheit.de>
 * @author Salih Özdemir <s.oezdemir@agentur-fahrenheit.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class BackendController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * webcheckRepository
     *
     * @var \RKW\RkwWebcheck\Domain\Repository\WebcheckRepository
     * @inject
     */
    protected $webcheckRepository;

    /**
     * checkResultRepository
     *
     * @var \RKW\RkwWebcheck\Domain\Repository\CheckResultRepository
     * @inject
     */
    protected $checkResultRepository;

    /**
     * backendHelper
     *
     * @var \RKW\RkwWebcheck\Utility\Backend
     * @inject
     */
    protected $backendHelper;


    /**
     * action listAction
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Webcheck $webcheck
     * @return void
     */
    public function listAction(Webcheck $webcheck = null)
    {
        if ($webcheck) {
            $this->view->assign('checkResultList', $this->checkResultRepository->getCompletedByCheckId($webcheck->getUid(), false));
            $this->view->assign('webcheck', $webcheck->getUid());
        } else {
            $this->view->assign('webcheckList', $this->webcheckRepository->findAllOrderByName());
        }
    }


    /**
     * action resultAction
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Webcheck $webcheck
     * @param \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
     * @return void
     */
    public function resultAction
    (
        Webcheck $webcheck,
        CheckResult $checkResult = null
    )
    {
        if ($checkResult) {
            $this->view->assign('checkResult', $checkResult);
            $this->view->assign('frontendUser', $checkResult->getFeUser());
        }
        $this->view->assign('webcheckResultList', $this->checkResultRepository->findByWebcheck($webcheck));
        $this->view->assign('benchmark', $this->backendHelper->getCheckBenchmark($webcheck, $this->checkResultRepository->getCompletedByCheckId($webcheck->getUid(), true)));
        $this->view->assign('webcheck', $webcheck);
    }


    /**
     * action print
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Webcheck $webcheck
     * @param \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
     * @return void
     */
    public function printAction
    (
        Webcheck $webcheck,
        CheckResult $checkResult = null
    )
    {
        $this->view->assign('webcheckResultList', $this->checkResultRepository->findByWebcheck($webcheck));
        $this->view->assign('webcheck', $webcheck);
        $this->view->assign('benchmark', $this->backendHelper->getCheckBenchmark($webcheck, $this->checkResultRepository->getCompletedByCheckId($webcheck->getUid(), true)));
        if ($checkResult) {
            $this->view->assign('checkResult', $checkResult);
            $this->view->assign('frontendUser', $checkResult->getFeUser());
        }
    }


    /**
     * action pdf
     *
     * @ignore pdf version is not used because it can't display google-API virtualization - but it works so far
     * @param \RKW\RkwWebcheck\Domain\Model\Webcheck $webcheck
     * @param \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
     * @return void
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3Fluid\Fluid\View\Exception\InvalidTemplateResourceException
     */
    public function pdfAction
    (
        Webcheck $webcheck,
        CheckResult $checkResult = null
    )
    {
        try {

            if ($settingsFramework = Common::getTyposcriptConfiguration($this->extensionName, ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK)) {

                /** @var \TYPO3\CMS\Fluid\View\StandaloneView $standaloneView */
                $standaloneView = GeneralUtility::makeInstance(\TYPO3\CMS\Fluid\View\StandaloneView::class);
                $standaloneView->setLayoutRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['layoutRootPaths'][0])));
                $standaloneView->setPartialRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['partialRootPaths'][0])));
                $standaloneView->setTemplateRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['templateRootPaths'][0])));
                $standaloneView->setTemplate('Backend/Pdf.html');
                $standaloneView->assign('webcheckResultList', $this->checkResultRepository->findByWebcheck($webcheck));
                $standaloneView->assign('webcheck', $webcheck);
                $standaloneView->assign('benchmark', $this->backendHelper->getCheckBenchmark($webcheck, $this->checkResultRepository->getCompletedByCheckId($webcheck->getUid(), true)));
                if ($checkResult) {
                    $standaloneView->assign('checkResult', $checkResult);
                    $standaloneView->assign('frontendUser', $checkResult->getFeUser());
                }

                ob_start();

                $content = $standaloneView->render();

                $html2pdf = new Html2Pdf('P', 'A4', 'de', true, 'UTF-8', 3);
                $html2pdf->pdf->IncludeJS("print(true);");
                //$html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content);
                $html2pdf->output('benchmark.pdf');
            }
        } catch (Html2PdfException $e) {
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }
}

