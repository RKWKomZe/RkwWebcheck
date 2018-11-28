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
 * Class Topic
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Philipp Grigoleit <p.grigoleit@agentur-fahrenheit.de>
 * @author Salih Özdemir <s.oezdemir@agentur-fahrenheit.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Topic extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * name
     *
     * @var string
     * @validate NotEmpty
     */
    protected $name;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * weight
     *
     * @var float
     */
    protected $weight = 0.0;

    /**
     * resultA
     *
     * @var string
     */
    protected $resultA;

    /**
     * resultB
     *
     * @var string
     */
    protected $resultB;

    /**
     * resultC
     *
     * @var string
     */
    protected $resultC;

    /**
     * questions
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\Question>
     * @cascade remove
     */
    protected $questions;

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the weight
     *
     * @return float $weight
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Sets the weight
     *
     * @param float $weight
     * @return void
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * Returns the resultA
     *
     * @return string $resultA
     */
    public function getResultA()
    {
        return $this->resultA;
    }

    /**
     * Sets the resultA
     *
     * @param string $resultA
     * @return void
     */
    public function setResultA($resultA)
    {
        $this->resultA = $resultA;
    }

    /**
     * Returns the resultB
     *
     * @return string $resultB
     */
    public function getResultB()
    {
        return $this->resultB;
    }

    /**
     * Sets the resultB
     *
     * @param string $resultB
     * @return void
     */
    public function setResultB($resultB)
    {
        $this->resultB = $resultB;
    }

    /**
     * Returns the resultC
     *
     * @return string $resultC
     */
    public function getResultC()
    {
        return $this->resultC;
    }

    /**
     * Sets the resultC
     *
     * @param string $resultC
     * @return void
     */
    public function setResultC($resultC)
    {
        $this->resultC = $resultC;
    }

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
        $this->questions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a Question
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Question $question
     * @return void
     */
    public function addQuestion(\RKW\RkwWebcheck\Domain\Model\Question $question)
    {
        $this->questions->attach($question);
    }

    /**
     * Removes a Question
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Question $questionToRemove The Question to be removed
     * @return void
     */
    public function removeQuestion(\RKW\RkwWebcheck\Domain\Model\Question $questionToRemove)
    {
        $this->questions->detach($questionToRemove);
    }

    /**
     * Returns the questions
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\Question> $questions
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Sets the questions
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\Question> $questions
     * @return void
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }
}
