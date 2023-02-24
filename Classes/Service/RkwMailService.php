<?php
namespace RKW\RkwWebcheck\Service;
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

use RKW\RkwMailer\Service\MailService;
use RKW\RkwWebcheck\Domain\Repository\BackendUserRepository;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use Madj2k\CoreExtended\Utility\GeneralUtility;
use RKW\RkwWebcheck\Domain\Model\FrontendUser;
use RKW\RkwWebcheck\Domain\Model\CheckResult;

/**
 * RkwMailService
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class RkwMailService implements \TYPO3\CMS\Core\SingletonInterface
{
	/**
	 * Notify admin about new check result
	 *
	 * @param array $adminIds
	 * @param \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
	 * @param int $pageId
	 * @return void
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \RKW\RkwMailer\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3Fluid\Fluid\View\Exception\InvalidTemplateResourceException
     */
	public function notifyCheckResultAdmin (
		array $adminIds,
		CheckResult $checkResult,
		int $pageId
	): void {

		if (
			($settingsFramework = GeneralUtility::getTypoScriptConfiguration(
                'Rkwwebcheck',
                ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
            ))
			&& ((isset($settingsFramework['view'])))
			&& ((isset($settingsFramework['view']['templateRootPaths'])))
		) {

			/** @var \RKW\RkwMailer\Service\MailService $mailService */
			$mailService = GeneralUtility::makeInstance(MailService::class);
			/** @var \RKW\RkwWebcheck\Domain\Repository\BackendUserRepository $backendUserRepository */
			$backendUserRepository = GeneralUtility::makeInstance(BackendUserRepository::class);

			foreach ($adminIds as $adminId) {

				/** @var \RKW\RkwWebcheck\Domain\Model\BackendUser $admin */
				if ($admin = $backendUserRepository->findByUid($adminId)) {
					$mailService->setTo($admin, array(
						'marker' => array(
							'backendUser' => $admin,
							'pageUid' => $pageId,
							'checkResult' => $checkResult,
						),
						'subject' => \RKW\RkwMailer\Utility\FrontendLocalizationUtility::translate(
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
				\RKW\RkwMailer\Utility\FrontendLocalizationUtility::translate(
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
	 * @param int $sharedPage
	 * @param string $hash
	 * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \RKW\RkwMailer\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3Fluid\Fluid\View\Exception\InvalidTemplateResourceException
     */
	public function shareResultUser (
			FrontendUser $frontendUser,
			CheckResult $checkResult,
			array $emailArray,
			int $sharedPage,
			string $hash
	): array {

		$errorMessages = [];
		if (
            ($settingsFramework = GeneralUtility::getTypoScriptConfiguration(
                'Rkwwebcheck',
                ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
            ))
            && (isset($settingsFramework['view']))
            && (isset($settingsFramework['view']['templateRootPaths']))
		){

			/** @var \RKW\RkwMailer\Service\MailService $mailService */
			$mailService = GeneralUtility::makeInstance(MailService::class);
			foreach ($emailArray as $email) {

				if (! \RKW\RkwRegistration\Utility\FrontendUserUtility::isEmailValid($email)) {

					$errorMessages[] = 	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'webcheckController.warning.invalidEmail',
                        'rkw_webcheck',
                        array($email)
                    );
					continue;
				}

				$marker = array(
					'frontendUser' => $frontendUser,
					'pageUid'      => $sharedPage,
					'checkResult'  => $checkResult,
					'hash'         => $hash,
					'anonymous'    => true
				);

				if (
					(! $frontendUser instanceof \RKW\RkwRegistration\Domain\Model\GuestUser)
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
				(! $frontendUser instanceof \RKW\RkwRegistration\Domain\Model\GuestUser)
				&& ($frontendUser->getLastName())
				&& ($frontendUser->getFirstName())
			){

				// set default subject
				$mailService->getQueueMail()->setSubject(
					\RKW\RkwMailer\Utility\FrontendLocalizationUtility::translate(
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
					\RKW\RkwMailer\Utility\FrontendLocalizationUtility::translate(
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
	}


	/**
	 * Send feedback to admin
	 *
	 * @param array $adminIds
	 * @param \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
	 * @param int $grade
	 * @param string $remarks
	 * @return void
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \RKW\RkwMailer\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
	 */
	public function sendFeedbackAdmin (
		array $adminIds,
		CheckResult $checkResult,
		int $grade,
		string $remarks
	): void {
		if (
			($settingsFramework = GeneralUtility::getTypoScriptConfiguration(
                'Rkwwebcheck',
                ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
            ))
			&& ((isset($settingsFramework['view'])))
			&& ((isset($settingsFramework['view']['templateRootPaths'])))
		) {

			/** @var \RKW\RkwMailer\Service\MailService $mailService */
			$mailService =GeneralUtility::makeInstance(MailService::class);

			/** @var \RKW\RkwWebcheck\Domain\Repository\BackendUserRepository $backendUserRepository */
			$backendUserRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(BackendUserRepository::class);

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
						'subject' => \RKW\RkwMailer\Utility\FrontendLocalizationUtility::translate(
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
				\RKW\RkwMailer\Utility\FrontendLocalizationUtility::translate(
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
