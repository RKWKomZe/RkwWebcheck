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
     * crdate
     *
     * @var int
     */
    protected $crdate;

    /**
     * tstamp
     *
     * @var int
     */
    protected $tstamp;

    /**
     * feUser
     *
     * @var \RKW\RkwWebcheck\Domain\Model\FrontendUser
     */
    protected $feUser = null;

    /**
     * sum
     *
     * @var int
     */
    protected $sum = 0;


    /**
     * percentage
     *
     * @var float
     */
    protected $percentage = 0.0;

    /**
     * completed
     *
     * @var boolean
     */
    protected $completed = false;

    /**
     * sendNotification
     *
     * @var bool
     */
    protected $sendNotification = false;

    /**
     * notificationTimestamp
     *
     * @var int
     */
    protected $notificationTimestamp;

    /**
     * results
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\TopicResult>
     * @cascade remove
     */
    protected $results = null;

    /**
     * lasttopic
     *
     * @var \RKW\RkwWebcheck\Domain\Model\Topic
     */
    protected $lastTopic = null;

    /**
     * lastquestion
     *
     * @var \RKW\RkwWebcheck\Domain\Model\Question
     */
    protected $lastQuestion = null;

    /**
     * webcheck
     *
     * @var \RKW\RkwWebcheck\Domain\Model\Webcheck
     */
    protected $webcheck;

    /**
     * humanReadableLabel
     *
     * @var string
     */
    protected $humanReadableLabel;


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
     * @return int $crdate
     */
    public function getCrdate()
    {
        return $this->crdate;
    }


    /**
     * Returns the crdate
     *
     * @param string $format
     * @return int $crdate
     */
    public function getCrdateFormated($format = 'd.m.Y - H:i \U\h\r')
    {
        return date($format, $this->crdate);
    }

    /**
     * Returns the tstamp
     *
     * @return int $tstamp
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }


    /**
     * Returns the feUser
     *
     * @return \RKW\RkwWebcheck\Domain\Model\FrontendUser $feUser
     */
    public function getFeUser()
    {
        return $this->feUser;
    }

    /**
     * Sets the feUser
     *
     * @param \RKW\RkwWebcheck\Domain\Model\\FrontendUser $feUser
     * @return void
     */
    public function setFeUser($feUser)
    {
        $this->feUser = $feUser;
    }

    /**
     * Deletes the feUser
     *
     * @return void
     */
    public function deleteFeUser()
    {
        $this->feUser = null;
    }

    /**
     * Returns the sum
     *
     * @return int $sum
     */
    public function getSum()
    {
        return $this->sum;
    }


    /**
     * Sets the sum
     *
     * @param int $sum
     * @return void
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    /**
     * Returns the percentage
     *
     * @return int $percentage
     */
    public function getPercentage()
    {
        return $this->percentage;
    }


    /**
     * Sets the percentage
     *
     * @param int $percentage
     * @return void
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
    }


    /**
     * Returns the completed
     *
     * @return bool $completed
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Sets the completed
     *
     * @param bool $completed
     * @return void
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;
    }

    /**
     * Returns the sendNotification
     *
     * @return bool $sendNotification
     */
    public function getSendNotification()
    {
        return $this->sendNotification;
    }

    /**
     * Sets the sendNotification
     *
     * @param bool $sendNotification
     * @return void
     */
    public function setSendNotification($sendNotification)
    {
        $this->sendNotification = $sendNotification;
    }

    /**
     * Returns the boolean state of sendNotification
     *
     * @return bool
     */
    public function isSendNotification()
    {
        return $this->sendNotification;
    }

    /**
     * Returns the notificationTimestamp
     *
     * @return int $notificationTimestamp
     */
    public function getNotificationTimestamp()
    {
        return $this->notificationTimestamp;
    }

    /**
     * Sets the notificationTimestamp
     *
     * @param int $notificationTimestamp
     * @return void
     */
    public function setNotificationTimestamp($notificationTimestamp)
    {
        $this->notificationTimestamp = $notificationTimestamp;
    }

    /**
     * Adds a TopicResult
     *
     * @param \RKW\RkwWebcheck\Domain\Model\TopicResult $result
     * @return void
     */
    public function addResult(\RKW\RkwWebcheck\Domain\Model\TopicResult $result)
    {
        $this->results->attach($result);
    }

    /**
     * Removes a TopicResult
     *
     * @param \RKW\RkwWebcheck\Domain\Model\TopicResult $resultToRemove The TopicResult to be removed
     * @return void
     */
    public function removeResult(\RKW\RkwWebcheck\Domain\Model\TopicResult $resultToRemove)
    {
        $this->results->detach($resultToRemove);
    }

    /**
     * Returns the results
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\TopicResult> $results
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Sets the results
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\TopicResult> $results
     * @return void
     */
    public function setResults($results)
    {
        $this->results = $results;
    }

    /**
     * Returns lastTopic
     *
     * @return \RKW\RkwWebcheck\Domain\Model\Topic $lastTopic
     */
    public function getLastTopic()
    {
        return $this->lastTopic;
    }

    /**
     * Sets lastTopic
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Topic $lastTopic
     * @return void
     */
    public function setLastTopic(\RKW\RkwWebcheck\Domain\Model\Topic $lastTopic)
    {
        $this->lastTopic = $lastTopic;
    }

    /**
     * Returns lastQuestion
     *
     * @return \RKW\RkwWebcheck\Domain\Model\Question $lastQuestion
     */
    public function getLastQuestion()
    {
        return $this->lastQuestion;
    }

    /**
     * Sets lastQuestion
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Question $lastQuestion
     * @return void
     */
    public function setLastQuestion(\RKW\RkwWebcheck\Domain\Model\Question $lastQuestion)
    {
        $this->lastQuestion = $lastQuestion;
    }

    /**
     * Returns the webcheck
     *
     * @return \RKW\RkwWebcheck\Domain\Model\Webcheck $webcheck
     */
    public function getWebcheck()
    {
        return $this->webcheck;
    }

    /**
     * Sets the webcheck
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Webcheck $webcheck
     * @return void
     */
    public function setWebcheck(\RKW\RkwWebcheck\Domain\Model\Webcheck $webcheck)
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
    public function getHumanReadableLabel()
    {
        // 1. Formatted timestamp
        $label = date("d.m.Y", $this->getTstamp());
        // 2. Total Points
        $label .= ' - ' . $this->getSum() . ' ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwebcheck_domain_model_checkresult.points', 'rkw_webcheck');
        // 3. Percentage
        $label .= ' - ' . $this->getPercentage() . "%";
        // 4. Users name
        if ($this->getFeUser()) {
            if ($this->getFeUser()->getTxRkwregistrationIsAnonymous()) {
                $label .= ' - ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwebcheck_domain_model_checkresult.anonymous', 'rkw_webcheck');
            } else {
                $label .= ' - ' . $this->getFeUser()->getFirstName() . ' ' . $this->getFeUser()->getLastName();
            }
        } else {
            $label .= ' - ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwebcheck_domain_model_checkresult.userDeleted', 'rkw_webcheck');
        }

        return $label;
        //===
    }


    /**
     * getResultByTopic
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Topic $topic
     * @return \RKW\RkwWebcheck\Domain\Model\TopicResult|object|boolean $result
     */
    public function getResultByTopic(\RKW\RkwWebcheck\Domain\Model\Topic $topic)
    {
        foreach ($this->results as $result) {
            if ($result->getTopic() == $topic) {
                return $result;
                //===
            }
        }

        return false;
        //===
    }
}
