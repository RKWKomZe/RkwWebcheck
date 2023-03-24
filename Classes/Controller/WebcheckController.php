<?php
namespace RKW\RkwWebcheck\Controller;

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

use Madj2k\CoreExtended\Utility\SiteUtility;
use Madj2k\FeRegister\Utility\FrontendUserSessionUtility;
use Madj2k\FeRegister\Utility\FrontendUserUtility;
use Madj2k\Postmaster\Mail\MailMassage;
use Madj2k\FeRegister\Domain\Model\GuestUser;
use Madj2k\CoreExtended\Utility\GeneralUtility;
use Madj2k\Postmaster\Mail\MailMessage;
use RKW\RkwWebcheck\Domain\Model\CheckResult;
use RKW\RkwWebcheck\Domain\Model\FrontendUser;
use RKW\RkwWebcheck\Domain\Model\QuestionResult;
use RKW\RkwWebcheck\Domain\Model\TopicResult;
use RKW\RkwWebcheck\Domain\Repository\BackendUserRepository;
use RKW\RkwWebcheck\Domain\Repository\CheckResultRepository;
use RKW\RkwWebcheck\Domain\Repository\FrontendUserRepository;
use RKW\RkwWebcheck\Domain\Repository\GlossaryRepository;
use RKW\RkwWebcheck\Domain\Repository\QuestionRepository;
use RKW\RkwWebcheck\Domain\Repository\QuestionResultRepository;
use RKW\RkwWebcheck\Domain\Repository\TopicRepository;
use RKW\RkwWebcheck\Domain\Repository\TopicResultRepository;
use RKW\RkwWebcheck\Domain\Repository\WebcheckRepository;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Class WebcheckController
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Philipp Grigoleit <p.grigoleit@agentur-fahrenheit.de>
 * @author Salih Özdemir <s.oezdemir@agentur-fahrenheit.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 */
class WebcheckController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * Signal name for use in ext_localconf.php
     *
     * @const string
     */
    const SIGNAL_AFTER_CHECK_FINISHED = 'afterCheckFinishedAdmin';


    /**
     * Signal name for use in ext_localconf.php
     *
     * @const string
     */
    const SIGNAL_SHARING = 'sharing';


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected PersistenceManager $persistenceManager;


    /**
     * @var \RKW\RkwWebcheck\Domain\Repository\WebcheckRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected WebcheckRepository $webcheckRepository;


    /**
     * @var \RKW\RkwWebcheck\Domain\Repository\CheckResultRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected CheckResultRepository $checkResultRepository;


    /**
     * @var \RKW\RkwWebcheck\Domain\Repository\QuestionRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected QuestionRepository $questionRepository;


    /**
     * @var \RKW\RkwWebcheck\Domain\Repository\QuestionResultRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected QuestionResultRepository $questionResultRepository;


    /**
     * @var \RKW\RkwWebcheck\Domain\Repository\TopicRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected TopicRepository $topicRepository;


    /**
     * @var \RKW\RkwWebcheck\Domain\Repository\TopicResultRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected TopicResultRepository $topicResultRepository;


    /**
     * @var \RKW\RkwWebcheck\Domain\Repository\FrontendUserRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected FrontendUserRepository $frontendUserRepository;


    /**
     * @var \RKW\RkwWebcheck\Domain\Repository\BackendUserRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected BackendUserRepository $backendUserRepository;


    /**
     * @var \RKW\RkwWebcheck\Domain\Repository\GlossaryRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected GlossaryRepository $glossaryRepository;


    /**
     * @var \TYPO3\CMS\Core\Log\Logger|null
     */
    protected ?Logger $logger;


    /**
     * returns the logged in FrontendUser - to be used in other functions
     *
     * @return int
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     */
    protected function getFrontendUserId(): int
    {
        return FrontendUserSessionUtility::getLoggedInUserId();
    }


    /**
     * Returns current logged in user object
     *
     * @return \RKW\RkwWebcheck\Domain\Model\FrontendUser|null
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     */
    protected function getFrontendUser():? FrontendUser
    {
        if (!$this->getFrontendUserId()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.notLoggedIn',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error');
        }

        return $this->frontendUserRepository->findByIdentifier($this->getFrontendUserId());

    }


    /**
     * action checkInit
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function checkInitAction(): void
    {
        /** @var \RKW\RkwWebcheck\Domain\Model\Webcheck $check */
        $check = $this->webcheckRepository->findByUid(intval($this->settings['check']));

        $this->view->assign('check', $check);
        $this->view->assign('frontendUser', $this->getFrontendUser());

        if ($this->settings['noStartScreen']) {
            $this->redirect('checkStart',
                null,
                null,
                array('terms' => 1)
            );
        }
    }


    /**
     * action checkStart
     *
     * @param bool $terms
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function checkStartAction(bool $terms = false): void
    {

        // 1. check terms
        if (!$terms) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.terms',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR

            );
            $this->redirect('checkInit');
        }

        // 2. initialize check
        /** @var \RKW\RkwWebcheck\Domain\Model\Webcheck $check */
        $check = $this->webcheckRepository->findByUid(intval($this->settings['check']));

        // 3. get the first topic and first question
        /** @var \RKW\RkwWebcheck\Domain\Model\Topic $topic */
        $topic = $check->getTopics()->current();

        /** @var \RKW\RkwWebcheck\Domain\Model\Question $question */
        $question = $topic->getQuestions()->current();

        // 4. build result-objects
        // Initialize new QuestionResult
        /** @var \RKW\RkwWebcheck\Domain\Model\QuestionResult $questionResult */
        $questionResult = GeneralUtility::makeInstance(QuestionResult::class);
        $questionResult->setWebcheck($check);
        $questionResult->setTopic($topic);
        $questionResult->setQuestion($question);
        $this->questionResultRepository->add($questionResult);

        // Initialize new TopicResult
        /** @var \RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult */
        $topicResult = GeneralUtility::makeInstance(TopicResult::class);
        $topicResult->setWebcheck($check);
        $topicResult->setTopic($topic);
        $topicResult->addResult($questionResult);
        $this->topicResultRepository->add($topicResult);

        // Initialize new CheckResult
        /** @var \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult */
        $checkResult = GeneralUtility::makeInstance(CheckResult::class);
        $checkResult->setFeUser($this->getFrontendUser());
        $checkResult->setWebcheck($check);
        $checkResult->addResult($topicResult);
        $checkResult->setLastTopic($topic);
        $checkResult->setLastQuestion($question);
        $this->checkResultRepository->add($checkResult);

        // Persist
        $this->persistenceManager->persistAll();

        $this->redirect(
            'showQuestionResult',
            null,
            null,
            ['questionResult' => $questionResult]
        );
    }


    /**
     * action questionShow
     *
     * @param \RKW\RkwWebcheck\Domain\Model\QuestionResult $questionResult
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function showQuestionResultAction(QuestionResult $questionResult): void
    {

        // 1. check if given questionResult belongs to logged in user
        if ($questionResult->getTopicResult()->getCheckResult()->getFeUser()->getUid() != $this->getFrontendUser()->getUid()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.invalidUser',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error');
        }

        // 2. Get topic and question - and positions
        /** @var \RKW\RkwWebcheck\Domain\Model\Topic $topic */
        $topic = $questionResult->getTopic();
        $topicPosition = $questionResult->getWebcheck()->getTopics()->getPosition($topic) - 1;

        /** @var \RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult */
        $topicResult = $questionResult->getTopicResult();
        $topicResultPosition = $questionResult->getTopicResult()->getCheckResult()->getResults()->getPosition($topicResult) - 1;

        /** @var \RKW\RkwWebcheck\Domain\Model\Question $question */
        $question = $questionResult->getQuestion();
        $questionPosition = $questionResult->getTopic()->getQuestions()->getPosition($question) - 1;

        // 3. get last topic and it's first questionResult
        $allTopicsArray = $questionResult->getWebcheck()->getTopics()->toArray();
        if (
            (is_array($allTopicsArray))
            && (isset($allTopicsArray[$topicPosition - 1]))
            && ($allTopicsArray[$topicPosition - 1] instanceof \RKW\RkwWebcheck\Domain\Model\Topic)
        ) {

            /** @var \RKW\RkwWebcheck\Domain\Model\Topic $lastTopic */
            $lastTopic = $allTopicsArray[$topicPosition - 1];
            $lastTopic->getQuestions()->rewind();

            /** @var \RKW\RkwWebcheck\Domain\Model\Question $firstQuestion*/
            $firstQuestion = $lastTopic->getQuestions()->current();

            $checkResult = $questionResult->getTopicResult()->getCheckResult();
            if ($lastTopicResult = $checkResult->getResultByTopic($lastTopic)) {
                if ($firstQuestionResult = $lastTopicResult->getResultByQuestion($firstQuestion)) {
                    $this->view->assign('lastTopicFirstQuestionResult', $firstQuestionResult);

                }
            }
        }

        // 4. Get last question
        $allQuestionArray = $questionResult->getTopic()->getQuestions()->toArray();
        if (
            is_array($allQuestionArray)
            && (isset($allQuestionArray[$questionPosition - 1]))
            && ($allQuestionArray[$questionPosition - 1] instanceof \RKW\RkwWebcheck\Domain\Model\Question)
        ) {
            $lastQuestion = $allQuestionArray[$questionPosition - 1];
            $lastQuestionResult = $topicResult->getResultByQuestion($lastQuestion);
            $this->view->assign('lastQuestionResult', $lastQuestionResult);
        }

        // 5. Assignments
        $this->view->assign('questionResult', $questionResult);
        $this->view->assign('questionPosition', $questionPosition + 1);
        $this->view->assign('maxQuestions', $questionResult->getTopic()->getQuestions()->count());
        $this->view->assign('topicPosition', $topicPosition + 1);
        $this->view->assign('maxTopics', $questionResult->getWebcheck()->getTopics()->count());
        $this->view->assign('glossaryList', $this->glossaryRepository->findByWebcheck($questionResult->getWebcheck()));

        // Assign arguments to control next Action
        if ($questionPosition == 0 && $topicPosition == 0) {
            $this->view->assign('firstQuestionAndTopic', 1);
        }
        if ($questionPosition == 0 && $topicPosition > 0) {
            $this->view->assign('firstQuestionNotTopic', 1);
        }
        if ($questionPosition == ($questionResult->getTopic()->getQuestions()->count() - 1)) {
            $this->view->assign('lastQuestion', 1);
        }
    }


    /**
     * action updateQuestionResult
     *
     * @param \RKW\RkwWebcheck\Domain\Model\QuestionResult $questionResult
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function updateQuestionResultAction(QuestionResult $questionResult): void
    {

        // 1. check if given questionResult belongs to logged in user
        if ($questionResult->getTopicResult()->getCheckResult()->getFeUser()->getUid() != $this->getFrontendUser()->getUid()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.invalidUser',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error');
        }

        // 2. get current topic and question
        /** @var \RKW\RkwWebcheck\Domain\Model\Topic $currentTopic */
        $topic = $questionResult->getTopic();
        $topicPosition = $questionResult->getWebcheck()->getTopics()->getPosition($topic) - 1;

        /** @var \RKW\RkwWebcheck\Domain\Model\Question $currentQuestion */
        $question = $questionResult->getQuestion();
        $questionPosition = $questionResult->getTopic()->getQuestions()->getPosition($question) - 1;

        // 3. save current values and update corresponding results
        $this->questionResultRepository->update($questionResult);

        // get checkResult and update status
        $checkResult = $questionResult->getTopicResult()->getCheckResult();
        $checkResult->setLastTopic($topic);
        $checkResult->setLastQuestion($question);
        $this->checkResultRepository->update($checkResult);

        // 4. Decide what to display next
        $allQuestionsArray = $topic->getQuestions()->toArray();
        if (
            (isset($allQuestionsArray[$questionPosition + 1]))
            && ($allQuestionsArray[$questionPosition + 1] instanceof \RKW\RkwWebcheck\Domain\Model\Question)
        ) {
            $newQuestion = $allQuestionsArray[$questionPosition + 1];

            // check if there already is a questionResult by checking the topic result
            /** @var \RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult */
            $topicResult = $questionResult->getTopicResult();
            $newQuestionResult = $topicResult->getResultByQuestion($newQuestion);

            // if not, initialize a new one!
            if (!$newQuestionResult) {

                /** @var \RKW\RkwWebcheck\Domain\Model\QuestionResult $newQuestionResult */
                $newQuestionResult = GeneralUtility::makeInstance(QuestionResult::class);
                $newQuestionResult->setWebcheck($questionResult->getWebcheck());
                $newQuestionResult->setTopic($questionResult->getTopic());
                $newQuestionResult->setQuestion($newQuestion);
                $this->questionResultRepository->add($newQuestionResult);

                $topicResult->addResult($newQuestionResult);
                $this->topicResultRepository->update($topicResult);

                // persist here because we need an existing object!
                $this->persistenceManager->persistAll();
            }

            $this->redirect('showQuestionResult', null, null, array(
                'questionResult' => $newQuestionResult,
            ));
        }

        $this->redirect('updateTopicResult', null, null, array(
            'topicResult' => $questionResult->getTopicResult(),
        ));
    }


    /**
     * action show topic
     *
     * @param \RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function showTopicResultAction(\RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult): void
    {

        // 1. check if given questionResult belongs to logged in user
        if ($topicResult->getCheckResult()->getFeUser()->getUid() != $this->getFrontendUser()->getUid()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.invalidUser',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error');
        }

        // 2. get current topic and question
        /** @var \RKW\RkwWebcheck\Domain\Model\Topic $currentTopic */
        $topic = $topicResult->getTopic();
        $topicPosition = $topicResult->getWebcheck()->getTopics()->getPosition($topic) - 1;

        /** @var \RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult */
        $checkResult = $topicResult->getCheckResult();

        // 4. Get new Topic from Webcheck
        $allTopicsArray = $topicResult->getWebcheck()->getTopics()->toArray();
        if (
            (is_array($allTopicsArray))
            && (isset($allTopicsArray[$topicPosition + 1]))
            && ($allTopicsArray[$topicPosition + 1] instanceof \RKW\RkwWebcheck\Domain\Model\Topic)
        ) {

            // get new topic
            /** @var \RKW\RkwWebcheck\Domain\Model\Topic $newTopic */
            $newTopic = $allTopicsArray[$topicPosition + 1];

            // get first question of new topic
            /** @var \RKW\RkwWebcheck\Domain\Model\Question $currentQuestion */
            $newTopic->getQuestions()->rewind();
            $firstQuestion = $newTopic->getQuestions()->current();

            // check if there already is a topicResult by checking the topic result
            $newTopicResult = $checkResult->getResultByTopic($newTopic);

            // if not, initialize a new one!
            // In this case we also need a new questionResult
            if (!$newTopicResult) {

                // init new QuestionResult
                /** @var \RKW\RkwWebcheck\Domain\Model\QuestionResult $newQuestionResult */
                $newQuestionResult = GeneralUtility::makeInstance(QuestionResult::class);
                $newQuestionResult->setWebcheck($topicResult->getWebcheck());
                $newQuestionResult->setTopic($newTopic);
                $newQuestionResult->setQuestion($firstQuestion);
                $this->questionResultRepository->add($newQuestionResult);

                // int new TopicResult and add QuestionResult
                /** @var \RKW\RkwWebcheck\Domain\Model\TopicResult $newTopicResult */
                $newTopicResult = GeneralUtility::makeInstance(TopicResult::class);
                $newTopicResult->setWebcheck($topicResult->getWebcheck());
                $newTopicResult->setTopic($newTopic);
                $newTopicResult->addResult($newQuestionResult);
                $this->questionResultRepository->add($newQuestionResult);

                // add new TopicResult to CheckResult and update last position
                $checkResult->addResult($newTopicResult);
                $this->checkResultRepository->update($checkResult);

                // persist here because we need an existing object!
                $this->persistenceManager->persistAll();
            }

            $this->view->assign('nextQuestionResult', $newTopicResult->getResultByQuestion($firstQuestion));
        }

        $topicResult->getResults()->rewind();
        $this->view->assign('firstQuestionResult', $topicResult->getResults()->current());

        $this->view->assign('topicResult', $topicResult);
        $this->view->assign('topicPosition', $topicPosition + 1);
        $this->view->assign('maxTopics', $topicResult->getWebcheck()->getTopics()->count());
        $this->view->assign('glossaryList', $this->glossaryRepository->findByWebcheck($topicResult->getWebcheck()));

        // Assign additional argument if last Topic in Check
        if ($topicPosition + 1 == $topicResult->getWebcheck()->getTopics()->count()) {
            $this->view->assign('endCheck', true);
        }
    }


    /**
     * action updateTopicResult
     *
     * @param \RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function updateTopicResultAction(TopicResult $topicResult): void
    {

        // 1. check if given questionResult belongs to logged in user
        if ($topicResult->getCheckResult()->getFeUser()->getUid() != $this->getFrontendUser()->getUid()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.invalidUser',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error');
        }

        // 2. get current topic
        /** @var \RKW\RkwWebcheck\Domain\Model\Topic $currentTopic */
        $topic = $topicResult->getTopic();

        // 3. Calculate topic results and save it
        $questionResults = $topicResult->getResults();
        $sum = 0;

        /** @var \RKW\RkwWebcheck\Domain\Model\QuestionResult $questionResult */
        foreach ($questionResults as $questionResult) {
            $sum += $questionResult->getSum();
        }
        $percent = ($sum / (count($questionResults) * 2)) * 100;

        $topicResult->setSum($sum);
        $topicResult->setPercentage($percent);
        $this->topicResultRepository->update($topicResult);

        $this->redirect('showTopicResult', null, null, array(
            'topicResult' => $topicResult,
        ));

    }


    /**
     * action checkFinished
     *
     * @param \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function showCheckResultAction(CheckResult $checkResult): void
    {

        // 1. check if given questionResult belongs to logged in user
        if ($checkResult->getFeUser()->getUid() != $this->getFrontendUser()->getUid()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.invalidUser',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error');
        }

        $this->view->assign('checkResult', $checkResult);
        $this->view->assign('frontendUser', $this->getFrontendUser());
        $this->view->assign('glossaryList', $this->glossaryRepository->findByWebcheck($checkResult->getWebcheck()));

    }


    /**
     * action updateCheckResultAction
     *
     * @param \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function updateCheckResultAction(CheckResult $checkResult): void
    {

        // 1. check if given questionResult belongs to logged in user
        if ($checkResult->getFeUser()->getUid() != $this->getFrontendUser()->getUid()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.invalidUser',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error');
        }

        // 2. Calculate final result
        $weightedSum = 0;
        $weightedTotalQuestions = 0;

        /** \RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult */
        foreach ($checkResult->getResults() as $topicResult) {
            $weightedSum += $topicResult->getSum() * $topicResult->getTopic()->getWeight();
            $weightedTotalQuestions += count($topicResult->getResults()) * $topicResult->getTopic()->getWeight();
        }
        $percent = ($weightedSum / ($weightedTotalQuestions * 2)) * 100;
        $checkResult->setSum($weightedSum);
        $checkResult->setPercentage($percent);

        // 4. Check for number of result
        $benchmarkMinChecks = ($this->settings['benchmarkMinChecks'] ? intval($this->settings['benchmarkMinChecks']) : 10);
        $numberOfExistentChecks = count($this->checkResultRepository->findByWebcheck($checkResult->getWebcheck()));
        if ($numberOfExistentChecks >= $benchmarkMinChecks) {
            $checkResult->setSendNotification(true);
        }

        try {

            // 5. Send email notification to admin
            if (
                ($checkResult->getCompleted() == 0)
                && (
                    $settingsFramework = GeneralUtility::getTypoScriptConfiguration(
                        'Rkwwebcheck',
                        ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
                    )
                )
                && (isset($settingsFramework['view']))
                && (isset($settingsFramework['view']['templateRootPaths']))
            ) {

                /** @var \Madj2k\Postmaster\Mail\MailMessage $mailService */
                $mailService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(MailMessage::class);
                $adminIds = GeneralUtility::trimExplode(',', $this->settings['notificationBackendUser']);

                if (
                    (is_array($adminIds))
                    && (count($adminIds))
                ) {
                    foreach ($adminIds as $adminId) {

                        if ($admin = $this->backendUserRepository->findByUid($adminId)) {

                            $mailService->setTo($admin, array(
                                'marker'  => array(
                                    'backendUser' => $admin,
                                    'pageUid'     => intval($GLOBALS['TSFE']->id),
                                    'checkResult' => $checkResult,
                                ),
                                'subject' => \Madj2k\Postmaster\Utility\FrontendLocalizationUtility::translate(
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
                        \Madj2k\Postmaster\Utility\FrontendLocalizationUtility::translate(
                            'rkwMailService.adminCheckFinished.subject',
                            'rkw_webcheck',
                            array($checkResult->getWebcheck()->getName()),
                            'de'
                        )
                    );

                    $mailService->getQueueMail()->addTemplatePaths($settingsFramework['view']['templateRootPaths']);
                    $mailService->getQueueMail()->setPlaintextTemplate('Email/AdminCheckFinished');
                    $mailService->getQueueMail()->setHtmlTemplate('Email/AdminCheckFinished');

                    // Send mail
                    $mailService->send();
                }
            }
        } catch (\Exception $e) {
            // do nothing
        }


        // 6. Set check to finished and update it
        $checkResult->setCompleted(true);
        $this->checkResultRepository->update($checkResult);

        $this->redirect('showCheckResult', null, null, array(
            'checkResult' => $checkResult,
        ));
    }


    /**
     * action shareCheckResult
     *
     * @param \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
     * @param string $emails
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function shareCheckResultAction(CheckResult $checkResult, string $emails = ''): void
    {

        // 1. check if given checkResult belongs to logged in user
        if ($checkResult->getFeUser()->getUid() != $this->getFrontendUser()->getUid()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.invalidUser',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error');
        }

        $sharedPage = intval($this->settings['sharedCheckPid']);
        $md5Params = $checkResult->getUid() . $checkResult->getWebcheck()->getUid() . $checkResult->getFeUser()->getUid();
        $hash = md5($md5Params);

        // 1. Check for emails
        $emailArray = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $emails, true);
        if (count($emailArray) < 1) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.noEmails',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );

            $this->redirect('showCheckResult', null, null, array(
                'checkResult' => $checkResult,
            ));
        }

        // 2. Send email
        try {
            if (
                (
                    $settingsFramework = GeneralUtility::getTypoScriptConfiguration(
                        'Rkwwebcheck',
                        ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
                    )
                )
                && (isset($settingsFramework['view']))
                && (isset($settingsFramework['view']['templateRootPaths']))
            ) {

                /** @var \Madj2k\Postmaster\Mail\MailMessage $mailService */
                $mailService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(MailMessage::class);
                foreach ($emailArray as $email) {

                    if (!\Madj2k\FeRegister\Utility\FrontendUserUtility::isEmailValid($email)) {
                        $this->addFlashMessage(
                            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                'webcheckController.warning.invalidEmail',
                                'rkw_webcheck',
                                array($email)
                            ),
                            null,
                            \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                        );
                        continue;
                    }

                    $marker = array(
                        'frontendUser' => $this->getFrontendUser(),
                        'pageUid'      => $sharedPage,
                        'checkResult'  => $checkResult,
                        'hash'         => $hash,
                        'anonymous'    => true,
                    );

                    if (
                        (! FrontendUserUtility::isGuestUser($this->getFrontendUser()))
                        && ($this->getFrontendUser()->getLastName())
                        && ($this->getFrontendUser()->getFirstName())
                    ) {
                        $marker['anonymous'] = false;
                    }

                    $mailService->setTo(
                        array(
                            'email' => $email,
                        ),
                        array(
                            'marker' => $marker,
                        )
                    );
                }

                if (
                    (! FrontendUserUtility::isGuestUser($this->getFrontendUser()))
                    && ($this->getFrontendUser()->getLastName())
                    && ($this->getFrontendUser()->getFirstName())
                ) {

                    // set default subject
                    $mailService->getQueueMail()->setSubject(
                        \Madj2k\Postmaster\Utility\FrontendLocalizationUtility::translate(
                            'rkwMailService.shareCheck.subject',
                            'rkw_webcheck',
                            array(
                                $this->getFrontendUser()->getFirstName(),
                                $this->getFrontendUser()->getLastName(),
                                $checkResult->getWebcheck()->getName(),
                            ),
                            SiteUtility::getCurrentTypo3Language()
                        )
                    );

                } else {
                    // set default subject
                    $mailService->getQueueMail()->setSubject(
                        \Madj2k\Postmaster\Utility\FrontendLocalizationUtility::translate(
                            'rkwMailService.shareCheck.subjectAnonymous',
                            'rkw_webcheck',
                            array(
                                $checkResult->getWebcheck()->getName(),
                            ),
                            SiteUtility::getCurrentTypo3Language()
                        )
                    );
                }


                // set template
                $mailService->getQueueMail()->addTemplatePaths($settingsFramework['view']['templateRootPaths']);
                $mailService->getQueueMail()->setPlaintextTemplate('Email/ShareCheck');
                $mailService->getQueueMail()->setHtmlTemplate('Email/ShareCheck');

                // send mail
                if (!$mailService->send()) {
                    throw new \Exception();
                };
            }

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.success.sentSharingEmails',
                    'rkw_webcheck'
                )
            );


        } catch (\Exception $e) {

            $this->getLogger()->log(
                \TYPO3\CMS\Core\Log\LogLevel::ERROR,
                'Error while trying to send sharing e-mail.'
            );
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.errorSendingSharingEmail',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
        }

        $this->redirect('showCheckResult', null, null, array(
            'checkResult' => $checkResult,
        ));

    }


    /**
     * action showSharedCheckResult
     *
     * @param \RKW\RkwWebcheck\Domain\Model\CheckResult|null $checkResult
     * @param string $hash
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function showSharedCheckResultAction(CheckResult $checkResult = null, string $hash = ''): void
    {

        // 1. Check basic values
        if (
            (!$checkResult)
            || (!$hash)
        ) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.missingParamsSharing',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error', null, null, null);
        }

        // 2. Check validity of hash-value
        $md5Params = $checkResult->getUid() . $checkResult->getWebcheck()->getUid() . $checkResult->getFeUser()->getUid();
        $hashInternal = md5($md5Params);
        if ($hashInternal != $hash) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.invalidHash',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error', null, null, null);
        }

        // 4. Assignments
        $this->view->assign('anonymous', true);

        if (
            (! $checkResult->getFeUser() instanceof \Madj2k\FeRegister\Domain\Model\GuestUser)
            && ($checkResult->getFeUser()->getLastName())
            && ($checkResult->getFeUser()->getFirstName())
        ) {
            $this->view->assign('anonymous', false);
        }

        $this->view->assign('checkResult', $checkResult);

    }


    /**
     * action showMyCheckResults
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function showMyCheckResultsAction()
    {
        // 1. Check if user is logged in
        if (!$this->getFrontendUser()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.notLoggedIn',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error');
        }

        $checkResults = $this->checkResultRepository->findByFeUser($this->getFrontendUser());
        if (
            (count($checkResults) < 1)
            && (intval($this->settings['newCheckPid']))
        ) {
            $this->redirect('checkInit', null, null, null,
                intval($this->settings['newCheckPid'])
            );
            //===
        }

        $this->view->assign('checkResults', $checkResults);
        $this->view->assign('frontendUser', $this->getFrontendUser());
    }


    /**
     * action edit
     *
     * @param \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function editCheckResultAction(CheckResult $checkResult): void
    {
        // 1. check if given checkResult belongs to logged in user
        if ($checkResult->getFeUser()->getUid() != $this->getFrontendUser()->getUid()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.invalidUser',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error');
        }

        // 2. if check is not completed, we start from the last question and last topic available
        if ($checkResult->getCompleted()) {

            $allTopicsArray = $checkResult->getWebcheck()->getTopics()->toArray();
            $firstQuestionResult = null;
            if (
                (is_array($allTopicsArray))
                && (isset($allTopicsArray[0]))
                && ($allTopicsArray[0] instanceof \RKW\RkwWebcheck\Domain\Model\Topic)
            ) {
                /** @var \RKW\RkwWebcheck\Domain\Model\Topic $firstTopic */
                $firstTopic = $allTopicsArray[0];
                $firstTopic->getQuestions()->rewind();
                $firstQuestion = $firstTopic->getQuestions()->current();

                /** @var \RKW\RkwWebcheck\Domain\Model\TopicResult $firstTopicResult */
                if ($firstTopicResult = $checkResult->getResultByTopic($firstTopic)) {

                    /** @var \RKW\RkwWebcheck\Domain\Model\QuestionResult $firstQuestionResult */
                    if ($firstQuestionResult = $firstTopicResult->getResultByQuestion($firstQuestion)) {
                        $this->redirect('showQuestionResult', null, null,
                            array(
                                'questionResult' => $firstQuestionResult,
                            ),
                            intval($checkResult->getWebcheck()->getCheckPid())
                        );
                    }
                }
            }

        } else {
            if (
                ($lastTopic = $checkResult->getLastTopic())
                && ($lastQuestion = $checkResult->getLastQuestion())
            ) {

                /** @var \RKW\RkwWebcheck\Domain\Model\TopicResult $lastTopicResult */
                if ($lastTopicResult = $checkResult->getResultByTopic($lastTopic)) {

                    /** @var \RKW\RkwWebcheck\Domain\Model\QuestionResult $lastQuestionResult */
                    if ($lastQuestionResult = $lastTopicResult->getResultByQuestion($lastQuestion)) {
                        $this->redirect('showQuestionResult', null, null,
                            array(
                                'questionResult' => $lastQuestionResult,
                            ),
                            intval($checkResult->getWebcheck()->getCheckPid())
                        );
                    }
                }

            }
        }

        $this->addFlashMessage(
            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                'webcheckController.warning.editError',
                'rkw_webcheck'
            ),
            null,
            \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
        );
        $this->redirect('showMyCheckResults');
    }


    /**
     * action deleteCheckResult
     *
     * @param \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function deleteCheckResultAction(CheckResult $checkResult)
    {

        // 1. check if given checkResult belongs to logged in user
        if ($checkResult->getFeUser()->getUid() != $this->getFrontendUser()->getUid()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.invalidUser',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error');
        }

        // 2. Delete checkResult
        $this->checkResultRepository->remove($checkResult);

        // 3. Add message
        $this->addFlashMessage(
            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                'webcheckController.success.checkDeleted',
                'rkw_webcheck'
            )
        );

        $this->redirect('showMyCheckResults');
    }


    /**
     * action showBenchmark
     *
     * @param \RKW\RkwWebcheck\Domain\Model\CheckResult|null $mainCheckResult
     * @param \RKW\RkwWebcheck\Domain\Model\CheckResult|null $compareCheckResult
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function showBenchmarkAction(CheckResult $mainCheckResult = null, CheckResult $compareCheckResult = null)
    {

        // 1. Checked if user is logged in
        if (!$this->getFrontendUser()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.notLoggedIn',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error');
        }

        // 2. Checked if user is not anonymous
        if (FrontendUserUtility::isGuestUser($this->getFrontendUser())) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'webcheckController.warning.noAnonymous',
                    'rkw_webcheck'
                ),
                null,
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('error');
        }

        // 3. Return results for selected check
        if (intval($this->settings['check'])) {

            // 3.1. Check for number of results
            $benchmarkMinChecks = ($this->settings['benchmarkMinChecks'] ? intval($this->settings['benchmarkMinChecks']) : 10);
            $allCheckResults = $this->checkResultRepository->findByWebcheckUid(intval($this->settings['check']));

            // 3.2 Get results of user
            $checkResults = $this->checkResultRepository->findCompletedByWebcheckIdAndFeUser(
                intval($this->settings['check']),
                $this->getFrontendUser()
            );

            if (count($checkResults) < 1) {
                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'webcheckController.warning.noChecks',
                        'rkw_webcheck'
                    ),
                    null,
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                );
                $this->redirect('error');
                //===
            }

            // 3.3 Set default if nothing is selected
            if (!$mainCheckResult) {
                $mainCheckResult = $checkResults->getFirst();
            }

            // 3.4 Calculate average over all checks
            $percentageAllChecks = 0;
            /** @var \RKW\RkwWebcheck\Domain\Model\CheckResult $tempCheckResult */
            foreach ($allCheckResults as $tempCheckResult) {
                $percentageAllChecks += $tempCheckResult->getPercentage();
            }
            $percentageAllChecks = round(($percentageAllChecks / count($allCheckResults)), 2);

            // 3.5 Build compare array
            $checkResultsWithoutSelected = array();
            foreach ($checkResults as $tempCheckResult) {
                if ($tempCheckResult->getUid() != $mainCheckResult->getUid()) {
                    $checkResultsWithoutSelected[] = $tempCheckResult;
                }
            }

            // 3.6 Assignments
            $this->view->assign('mainCheckResult', $mainCheckResult);
            $this->view->assign('compareCheckResult', $compareCheckResult);
            $this->view->assign('checkResults', $checkResults);
            $this->view->assign('checkResultsWithoutSelected', $checkResultsWithoutSelected);

            if (count($allCheckResults) >= $benchmarkMinChecks) {
                $this->view->assign('percentageAllChecks', $percentageAllChecks);
            }
        }
    }


    /**
     * action feedback
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \Madj2k\Postmaster\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3Fluid\Fluid\View\Exception\InvalidTemplateResourceException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     *  @todo rework this method!
     */
    public function feedbackAction()
    {
        $userId = $this->getFrontendUser()->getUid();
        $arguments = $this->request->getArguments();

        if (isset($arguments)) {
            $grade = $arguments['tx_rkwwebcheck']['note'];
            $remarks = $arguments['annotations'];

            try {
                $checks = $this->webcheckRepository->findAll();
            } catch (\Exception $e) {
                $this->forward('error', null, null, null);
            }

            if ($grade != null) {
                $this->view->assign('thankYou', true);
                $this->view->assign('user', $userId);
                $this->view->assign('Note:', $grade);
                $this->view->assign('Anmerkungen:', $remarks);

                /** @var \Madj2k\Postmaster\Mail\MailMessage $mailService */
                $mailService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(MailMessage::class);

                $mails = explode(",", $this->settings['email']);
                foreach ($mails as $mail) {
                    $mailService->setTo(
                        array(
                            'email' => $mail,
                        ),
                        array(
                            'subject' => 'Ein Feedback wurde gesendet',
                            'marker'  => array(
                                'grade'   => $grade,
                                'remarks' => $remarks,
                            ),
                        )
                    );
                }


                /**
                 * Set the templates. The templates are to be placed in the extension that uses the service.
                 */
                $mailService->getQueueMail()->setHtmlTemplate('feedback');
                $mailService->send();


            } else {
                $this->view->assign('thankYou', false);
                $this->view->assign('Check', $checks);
            }
        }

    }


    /**
     * action error
     *
     * @return void
     */
    public function errorAction()
    {
        $this->view->assign('startpage', $GLOBALS['TSFE']->domainStartPage);
    }


    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger(): Logger
    {

        if (!$this->logger instanceof \TYPO3\CMS\Core\Log\Logger) {
            $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        }

        return $this->logger;
    }


}

