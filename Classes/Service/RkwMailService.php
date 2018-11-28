<?php
namespace RKW\RkwWebcheck\Service;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use \RKW\RkwBasics\Helper\Common;
use \RKW\RkwWebcheck\Domain\Model\FrontendUser;
use \RKW\RkwWebcheck\Domain\Model\CheckResult;

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
 * RkwMailService
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class RkwMailService implements \TYPO3\CMS\Core\SingletonInterface
{
	/**
	 * Notify admin about new check result
	 *
	 * @param array $adminIds
	 * @param \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
	 * @param integer $pageId
	 *
	 * @return void
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \RKW\RkwMailer\Service\MailException
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Fluid\View\Exception\InvalidTemplateResourceException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
	 */
	public function notifyCheckResultAdmin (
		$adminIds,
		CheckResult $checkResult,
		$pageId
	) {

		if (
			($settingsFramework = Common::getTyposcriptConfiguration('Rkwwebcheck', ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK))
			&& ((isset($settingsFramework['view'])))
			&& ((isset($settingsFramework['view']['templateRootPaths'])))
		) {

			/** @var \RKW\RkwMailer\Service\MailService $mailService */
			$mailService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwMailer\\Service\\MailService');
			/** @var \RKW\RkwWebcheck\Domain\Repository\BackendUserRepository $backendUserRepository */
			$backendUserRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWebcheck\\Domain\\Repository\\BackendUserRepository');

			foreach ($adminIds as $adminId) {

				/** @var \RKW\RkwWebcheck\Domain\Model\BackendUser $admin */
				if ($admin = $backendUserRepository->findByUid($adminId)) {
					$mailService->setTo($admin, array(
						'marker' => array(
							'backendUser' => $admin,
							'pageUid' => $pageId,
							'checkResult' => $checkResult,
						),
						'subject' => \RKW\RkwMailer\Helper\FrontendLocalization::translate(
							'rkwMailService.adminCheckFinished.subject',
							'rkw_webcheck',
							array($checkResult->getWebcheck()->getName()),
							$admin->getLang()
						),
					));
				}
			}

			// set default subject
			$mailService->getQueueMail()->setSubject(
				\RKW\RkwMailer\Helper\FrontendLocalization::translate(
					'rkwMailService.adminCheckFinished.subject',
					'rkw_webcheck',
					array($checkResult->getWebcheck()->getName())
				)
			);

			$mailService->getQueueMail()->addTemplatePaths($settingsFramework['view']['templateRootPaths']);
			$mailService->getQueueMail()->setPlaintextTemplate($settingsFramework['view']['templateRootPaths'] . 'Email/AdminCheckFinished');
			$mailService->getQueueMail()->setHtmlTemplate($settingsFramework['view']['templateRootPaths'] . 'Email/AdminCheckFinished');

			// Send mail
			$mailService->send();
		}
	}



	/**
	 * Send mails to given eMail-addresses for sharing users check
	 *
	 * @param \RKW\RkwWebcheck\Domain\Model\FrontendUser $frontendUser
	 * @param \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
	 * @param array $emailArray
	 * @param integer $sharedPage
	 * @param string $hash
	 * @return array|boolean
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \RKW\RkwMailer\Service\MailException
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Fluid\View\Exception\InvalidTemplateResourceException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
	 */
	public function shareResultUser (
			FrontendUser $frontendUser,
			CheckResult $checkResult,
			$emailArray,
			$sharedPage,
			$hash
	) {

		$errorMessages = FALSE;

		if (
				($settingsFramework = Common::getTyposcriptConfiguration('Rkwwebcheck', ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK))
				&& (isset($settingsFramework['view']))
				&& (isset($settingsFramework['view']['templateRootPaths']))
		){

			/** @var \RKW\RkwMailer\Service\MailService $mailService */
			$mailService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwMailer\\Service\\MailService');
			foreach ($emailArray as $email) {

				if (! \RKW\RkwRegistration\Tools\Registration::validEmail($email)) {

					$errorMessages[] = 	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
											'webcheckController.warning.invalidEmail',
											'rkw_webcheck',
											array($email)
										);
					continue;
					//===
				}

				$marker = array(
					'frontendUser' => $frontendUser,
					'pageUid'      => $sharedPage,
					'checkResult'  => $checkResult,
					'hash'         => $hash,
					'anonymous'    => true
				);

				if (
					(! $frontendUser->getTxRkwregistrationIsAnonymous())
					&& ($frontendUser->getLastName())
					&& ($frontendUser->getFirstName())
				) {
					$marker['anonymous'] = false;
				}

				$mailService->setTo(
					array(
						'email' => $email,
					),
					array(
						'marker' => $marker
					)
				);
			}

			if (
				(! $frontendUser->getTxRkwregistrationIsAnonymous())
				&& ($frontendUser->getLastName())
				&& ($frontendUser->getFirstName())
			){

				// set default subject
				$mailService->getQueueMail()->setSubject(
					\RKW\RkwMailer\Helper\FrontendLocalization::translate(
						'rkwMailService.shareCheck.subject',
						'rkw_webcheck',
						array(
							$frontendUser->getFirstName(),
							$frontendUser->getLastName(),
							$checkResult->getWebcheck()->getName()
						),
						$frontendUser->getTxRkwregistrationLanguageKey()
					)
				);
			} else {
				// set default subject
				$mailService->getQueueMail()->setSubject(
					\RKW\RkwMailer\Helper\FrontendLocalization::translate(
						'rkwMailService.shareCheck.subjectAnonymous',
						'rkw_webcheck',
						array(
							$checkResult->getWebcheck()->getName()
						),
						$frontendUser->getTxRkwregistrationLanguageKey()
					)
				);
			}

			// set template
			$mailService->getQueueMail()->addTemplatePaths($settingsFramework['view']['templateRootPaths']);
			$mailService->getQueueMail()->setPlaintextTemplate($settingsFramework['view']['templateRootPaths'] . 'Email/ShareCheck');
			$mailService->getQueueMail()->setHtmlTemplate($settingsFramework['view']['templateRootPaths'] . 'Email/ShareCheck');

			// send mail
			$mailService->send();
		}

		return $errorMessages;
		//===
	}



	/**
	 * Send feedback to admin
	 *
	 * @param array $adminIds
	 * @param \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
	 * @param integer $grade
	 * @param string $remarks
	 *
	 * @return void
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \RKW\RkwMailer\Service\MailException
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Fluid\View\Exception\InvalidTemplateResourceException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
	 */
	public function sendFeedbackAdmin (
		$adminIds,
		CheckResult $checkResult,
		$grade,
		$remarks
	) {
		if (
			($settingsFramework = Common::getTyposcriptConfiguration('Rkwwebcheck', ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK))
			&& ((isset($settingsFramework['view'])))
			&& ((isset($settingsFramework['view']['templateRootPaths'])))
		) {

			/** @var \RKW\RkwMailer\Service\MailService $mailService */
			$mailService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwMailer\\Service\\MailService');
			/** @var \RKW\RkwWebcheck\Domain\Repository\BackendUserRepository $backendUserRepository */
			$backendUserRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWebcheck\\Domain\\Repository\\BackendUserRepository');

			foreach ($adminIds as $adminId) {

				/** @var \RKW\RkwWebcheck\Domain\Model\BackendUser $admin */
				if ($admin = $backendUserRepository->findByUid($adminId)) {
					$mailService->setTo($admin, array(
						'marker' => array(
							'backendUser' => $admin,
							'checkResult' => $checkResult,
							'grade' => $grade,
							'remarks' => $remarks
						),
						'subject' => \RKW\RkwMailer\Helper\FrontendLocalization::translate(
							'rkwMailService.adminFeedback.subject',
							'rkw_webcheck',
							array($checkResult->getWebcheck()->getName()),
							$admin->getLang()
						),
					));
				}
			}

			// set default subject
			$mailService->getQueueMail()->setSubject(
				\RKW\RkwMailer\Helper\FrontendLocalization::translate(
					'rkwMailService.adminFeedback.subject',
					'rkw_webcheck',
					array($checkResult->getWebcheck()->getName())
				)
			);

			$mailService->getQueueMail()->addTemplatePaths($settingsFramework['view']['templateRootPaths']);
			$mailService->getQueueMail()->setPlaintextTemplate($settingsFramework['view']['templateRootPaths'] . 'Email/AdminFeedback');
			$mailService->getQueueMail()->setHtmlTemplate($settingsFramework['view']['templateRootPaths'] . 'Email/AdminFeedback');

			// Send mail
			$mailService->send();
		}
	}

}
