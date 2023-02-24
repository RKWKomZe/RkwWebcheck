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
     * @var string
     */
    protected string $name = '';


    /**
     * @var string
     */
    protected string $description = '';


    /**
     * @var float
     */
    protected float $weight = 0.0;


    /**
     * @var string
     */
    protected string $resultA = '';


    /**
     * @var string
     */
    protected string $resultB = '';


    /**
     * @var string
     */
    protected string $resultC = '';


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\Question>|null
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?ObjectStorage $questions = null;


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
     * Returns the name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * Returns the description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }


    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }


    /**
     * Returns the weight
     *
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }


    /**
     * Sets the weight
     *
     * @param float $weight
     * @return void
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }


    /**
     * Returns the resultA
     *
     * @return string
     */
    public function getResultA(): string
    {
        return $this->resultA;
    }


    /**
     * Sets the resultA
     *
     * @param string $resultA
     * @return void
     */
    public function setResultA(string $resultA): void
    {
        $this->resultA = $resultA;
    }


    /**
     * Returns the resultB
     *
     * @return string
     */
    public function getResultB(): string
    {
        return $this->resultB;
    }


    /**
     * Sets the resultB
     *
     * @param string $resultB
     * @return void
     */
    public function setResultB(string $resultB): void
    {
        $this->resultB = $resultB;
    }


    /**
     * Returns the resultC
     *
     * @return string
     */
    public function getResultC(): string
    {
        return $this->resultC;
    }


    /**
     * Sets the resultC
     *
     * @param string $resultC
     * @return void
     */
    public function setResultC(string $resultC): void
    {
        $this->resultC = $resultC;
    }


    /**
     * Adds a Question
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Question $question
     * @return void
     */
    public function addQuestion(Question $question): void
    {
        $this->questions->attach($question);
    }

    /**
     * Removes a Question
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Question $questionToRemove The Question to be removed
     * @return void
     */
    public function removeQuestion(Question $questionToRemove): void
    {
        $this->questions->detach($questionToRemove);
    }


    /**
     * Returns the questions
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\Question>
     */
    public function getQuestions(): ObjectStorage
    {
        return $this->questions;
    }


    /**
     * Sets the questions
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\Question> $questions
     * @return void
     */
    public function setQuestions(ObjectStorage $questions): void
    {
        $this->questions = $questions;
    }
}
