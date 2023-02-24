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

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class TopicResult
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Philipp Grigoleit <p.grigoleit@agentur-fahrenheit.de>, Fahrenheit GmbH
 * @author Salih Özdemir <s.oezdemir@agentur-fahrenheit.de>, Fahrenheit GmbH
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 */
class TopicResult extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var int
     */
    protected int $sum = 0;


    /**
     * @var float
     */
    protected float $percentage = 0.0;


    /**
     * @var \RKW\RkwWebcheck\Domain\Model\Webcheck|null
     */
    protected ?Webcheck $webcheck = null;


    /**
     * @var \RKW\RkwWebcheck\Domain\Model\Topic|null
     */
    protected ?Topic $topic = null;


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\QuestionResult>|null
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?ObjectStorage $results = null;


    /**
     *  checkResult
     *
     * @var \RKW\RkwWebcheck\Domain\Model\CheckResult|null
     */
    protected ?CheckResult $checkResult = null;


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
     * Returns the sum
     *
     * @return int
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
     * @return float $percentage
     */
    public function getPercentage(): float
    {
        return $this->percentage;
    }


    /**
     * Sets the percentage
     *
     * @param float $percentage
     * @return void
     */
    public function setPercentage(float $percentage): void
    {
        $this->percentage = $percentage;
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
     * Returns the topic
     *
     * @return \RKW\RkwWebcheck\Domain\Model\Topic $topic
     */
    public function getTopic():? Topic
    {
        return $this->topic;
    }


    /**
     * Sets the topic
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Topic $topic
     * @return void
     */
    public function setTopic(Topic $topic): void
    {
        $this->topic = $topic;
    }


    /**
     * Returns the checkResult
     *
     * @return \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
     */
    public function getCheckResult():? CheckResult
    {
        return $this->checkResult;
    }


    /**
     * Sets the checkResult
     *
     * @param \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult
     * @return void
     */
    public function setCheckResult(CheckResult $checkResult): void
    {
        $this->checkResult = $checkResult;
    }


    /**
     * Adds a QuestionResult
     *
     * @param \RKW\RkwWebcheck\Domain\Model\QuestionResult $result
     * @return void
     */
    public function addResult(QuestionResult $result): void
    {
        $this->results->attach($result);
    }


    /**
     * Removes a QuestionResult
     *
     * @param \RKW\RkwWebcheck\Domain\Model\QuestionResult $resultToRemove The QuestionResult to be removed
     * @return void
     */
    public function removeResult(QuestionResult $resultToRemove): void
    {
        $this->results->detach($resultToRemove);
    }


    /**
     * Returns the results
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\QuestionResult>
     */
    public function getResults():? ObjectStorage
    {
        return $this->results;
    }


    /**
     * Sets the results
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\QuestionResult> $results
     * @return void
     */
    public function setResults(ObjectStorage $results): void
    {
        $this->results = $results;
    }


    /**
     * Returns the result
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Question $question
     * @return \RKW\RkwWebcheck\Domain\Model\QuestionResult|null
     */
    public function getResultByQuestion(Question $question):? QuestionResult
    {
        foreach ($this->results as $result) {
            if ($result->getQuestion() == $question) {
                return $result;
            }
        }

        return null;
    }
}
