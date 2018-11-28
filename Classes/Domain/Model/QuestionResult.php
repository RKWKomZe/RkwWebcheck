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
 * Class QuestionResult
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Philipp Grigoleit <p.grigoleit@agentur-fahrenheit.de>
 * @author Salih Özdemir <s.oezdemir@agentur-fahrenheit.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class QuestionResult extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * sum
     *
     * @var int
     */
    protected $sum = 0;

    /**
     * webcheck
     *
     * @var \RKW\RkwWebcheck\Domain\Model\Webcheck
     */
    protected $webcheck;

    /**
     * topic
     *
     * @var \RKW\RkwWebcheck\Domain\Model\Topic
     */
    protected $topic;

    /**
     * question
     *
     * @var \RKW\RkwWebcheck\Domain\Model\Question
     */
    protected $question;

    /**
     * topicResult
     *
     * @var \RKW\RkwWebcheck\Domain\Model\TopicResult
     */
    protected $topicResult;

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
     * Returns the topic
     *
     * @return \RKW\RkwWebcheck\Domain\Model\Topic $topic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Sets the topic
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Topic $topic
     * @return void
     */
    public function setTopic(\RKW\RkwWebcheck\Domain\Model\Topic $topic)
    {
        $this->topic = $topic;
    }

    /**
     * Returns the question
     *
     * @return \RKW\RkwWebcheck\Domain\Model\Question $question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Sets the question
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Question $question
     * @return void
     */
    public function setQuestion(\RKW\RkwWebcheck\Domain\Model\Question $question)
    {
        $this->question = $question;
    }


    /**
     * Returns the topicResult
     *
     * @return \RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult
     */
    public function getTopicResult()
    {
        return $this->topicResult;
    }

    /**
     * Sets the topicResult
     *
     * @param \RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult
     * @return void
     */
    public function setTopicResult(\RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult)
    {
        $this->topicResult = $topicResult;
    }
}
