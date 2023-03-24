<?php
namespace RKW\RkwWebcheck\Domain\Model;

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

use Madj2k\FeRegister\Domain\Model\GuestUser;
use Madj2k\FeRegister\Utility\FrontendUserUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class CheckResult
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Philipp Grigoleit <p.grigoleit@agentur-fahrenheit.de>
 * @author Salih Özdemir <s.oezdemir@agentur-fahrenheit.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CheckResult extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var int
     */
    protected int $crdate = 0;


    /**
     * @var int
     */
    protected int $tstamp = 0;


    /**
     * @var \RKW\RkwWebcheck\Domain\Model\FrontendUser|null
     */
    protected ?FrontendUser $feUser = null;


    /**
     * @var int
     */
    protected int $sum = 0;


    /**
     * @var float
     */
    protected float $percentage = 0.0;


    /**
     * @var bool
     */
    protected bool $completed = false;


    /**
     * @var bool
     */
    protected bool $sendNotification = false;


    /**
     * @var int
     */
    protected int $notificationTimestamp = 0;


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\TopicResult>|null
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?ObjectStorage $results = null;


    /**
     * @var \RKW\RkwWebcheck\Domain\Model\Topic|null
     */
    protected ?Topic $lastTopic = null;


    /**
     * @var \RKW\RkwWebcheck\Domain\Model\Question|null
     */
    protected ?Question $lastQuestion = null;


    /**
     * @var \RKW\RkwWebcheck\Domain\Model\Webcheck|null
     */
    protected ?Webcheck $webcheck = null;


    /**
     * @var string
     */
    protected string $humanReadableLabel = '';


    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }


    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->results = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }


    /**
     * Returns the crdate
     *
     * @return int
     */
    public function getCrdate(): int
    {
        return $this->crdate;
    }


    /**
     * Returns the crdate
     *
     * @param string $format
     * @return string
     */
    public function getCrdateFormated(string $format = 'd.m.Y - H:i \U\h\r'): string
    {
        return date($format, $this->crdate);
    }


    /**
     * Returns the tstamp
     *
     * @return int
     */
    public function getTstamp(): int
    {
        return $this->tstamp;
    }


    /**
     * Returns the feUser
     *
     * @return \RKW\RkwWebcheck\Domain\Model\FrontendUser $feUser
     */
    public function getFeUser():? FrontendUser
    {
        return $this->feUser;
    }


    /**
     * Sets the feUser
     *
     * @param \RKW\RkwWebcheck\Domain\Model\FrontendUser $feUser
     * @return void
     */
    public function setFeUser(FrontendUser $feUser): void
    {
        $this->feUser = $feUser;
    }


    /**
     * Deletes the feUser
     *
     * @return void
     */
    public function deleteFeUser(): void
    {
        $this->feUser = null;
    }


    /**
     * Returns the sum
     *
     * @return int $sum
     */
    public function getSum(): int
    {
        return $this->sum;
    }


    /**
     * Sets the sum
     *
     * @param int $sum
     * @return void
     */
    public function setSum(int $sum): void
    {
        $this->sum = $sum;
    }


    /**
     * Returns the percentage
     *
     * @return int $percentage
     */
    public function getPercentage(): int
    {
        return $this->percentage;
    }


    /**
     * Sets the percentage
     *
     * @param int $percentage
     * @return void
     */
    public function setPercentage(int $percentage): void
    {
        $this->percentage = $percentage;
    }


    /**
     * Returns the completed
     *
     * @return bool
     */
    public function getCompleted(): bool
    {
        return $this->completed;
    }


    /**
     * Sets the completed
     *
     * @param bool $completed
     * @return void
     */
    public function setCompleted(bool $completed): void
    {
        $this->completed = $completed;
    }


    /**
     * Returns the sendNotification
     *
     * @return bool
     */
    public function getSendNotification(): bool
    {
        return $this->sendNotification;
    }


    /**
     * Sets the sendNotification
     *
     * @param bool $sendNotification
     * @return void
     */
    public function setSendNotification(bool $sendNotification): void
    {
        $this->sendNotification = $sendNotification;
    }


    /**
     * Returns the boolean state of sendNotification
     *
     * @return bool
     */
    public function isSendNotification(): bool
    {
        return $this->sendNotification;
    }


    /**
     * Returns the notificationTimestamp
     *
     * @return int
     */
    public function getNotificationTimestamp(): int
    {
        return $this->notificationTimestamp;
    }


    /**
     * Sets the notificationTimestamp
     *
     * @param int $notificationTimestamp
     * @return void
     */
    public function setNotificationTimestamp(int $notificationTimestamp): void
    {
        $this->notificationTimestamp = $notificationTimestamp;
    }


    /**
     * Adds a TopicResult
     *
     * @param \RKW\RkwWebcheck\Domain\Model\TopicResult $result
     * @return void
     */
    public function addResult(TopicResult $result): void
    {
        $this->results->attach($result);
    }


    /**
     * Removes a TopicResult
     *
     * @param \RKW\RkwWebcheck\Domain\Model\TopicResult $resultToRemove The TopicResult to be removed
     * @return void
     */
    public function removeResult(TopicResult $resultToRemove): void
    {
        $this->results->detach($resultToRemove);
    }


    /**
     * Returns the results
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\TopicResult> $results
     */
    public function getResults(): ObjectStorage
    {
        return $this->results;
    }


    /**
     * Sets the results
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\TopicResult> $results
     * @return void
     */
    public function setResults(ObjectStorage $results): void
    {
        $this->results = $results;
    }


    /**
     * Returns lastTopic
     *
     * @return \RKW\RkwWebcheck\Domain\Model\Topic $lastTopic
     */
    public function getLastTopic():? Topic
    {
        return $this->lastTopic;
    }


    /**
     * Sets lastTopic
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Topic $lastTopic
     * @return void
     */
    public function setLastTopic(Topic $lastTopic): void
    {
        $this->lastTopic = $lastTopic;
    }


    /**
     * Returns lastQuestion
     *
     * @return \RKW\RkwWebcheck\Domain\Model\Question
     */
    public function getLastQuestion(): Question
    {
        return $this->lastQuestion;
    }


    /**
     * Sets lastQuestion
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Question $lastQuestion
     * @return void
     */
    public function setLastQuestion(Question $lastQuestion): void
    {
        $this->lastQuestion = $lastQuestion;
    }


    /**
     * Returns the webcheck
     *
     * @return \RKW\RkwWebcheck\Domain\Model\Webcheck $webcheck
     */
    public function getWebcheck():? Webcheck
    {
        return $this->webcheck;
    }


    /**
     * Sets the webcheck
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Webcheck $webcheck
     * @return void
     */
    public function setWebcheck(Webcheck $webcheck): void
    {
        $this->webcheck = $webcheck;
    }


    /**
     * To get a human readable label for select fields (used at BackendController->list)
     * (has no field in db)
     *
     * @author Maximilian Fäßler
     * @return string
     */
    public function getHumanReadableLabel(): string
    {
        // 1. Formatted timestamp
        $label = date("d.m.Y", $this->getTstamp());

        // 2. Total Points
        $label .= ' - ' . $this->getSum() . ' ' . LocalizationUtility::translate('tx_rkwwebcheck_domain_model_checkresult.points', 'rkw_webcheck');

        // 3. Percentage
        $label .= ' - ' . $this->getPercentage() . "%";

        // 4. Users name
        if ($this->getFeUser()) {
            if (FrontendUserUtility::isGuestUser($this->getFeUser())) {
                $label .= ' - ' . LocalizationUtility::translate('tx_rkwwebcheck_domain_model_checkresult.anonymous', 'rkw_webcheck');
            } else {
                $label .= ' - ' . $this->getFeUser()->getFirstName() . ' ' . $this->getFeUser()->getLastName();
            }
        } else {
            $label .= ' - ' . LocalizationUtility::translate('tx_rkwwebcheck_domain_model_checkresult.userDeleted', 'rkw_webcheck');
        }

        return $label;
    }


    /**
     * getResultByTopic
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Topic $topic
     * @return \RKW\RkwWebcheck\Domain\Model\TopicResult|null $result
     */
    public function getResultByTopic(Topic $topic):? TopicResult
    {
        foreach ($this->results as $result) {
            if ($result->getTopic() == $topic) {
                return $result;
            }
        }

        return null;
    }
}
