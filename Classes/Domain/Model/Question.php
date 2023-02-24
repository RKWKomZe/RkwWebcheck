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
 * Class Question
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Philipp Grigoleit <p.grigoleit@agentur-fahrenheit.de>
 * @author Salih Özdemir <s.oezdemir@agentur-fahrenheit.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Question extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var string
     */
    protected string $question = '';


    /**
     * @var string
     */
    protected string $description = '';


    /**
     * @var string
     */
    protected string $answer1 = '';


    /**
     * @var string
     */
    protected string $result1 = '';


    /**
     * @var int
     */
    protected int $value1 = 0;


    /**
     * @var string
     */
    protected string $answer2 = '';


    /**
     * @var string
     */
    protected string $result2 = '';


    /**
     * @var int
     */
    protected int $value2 = 0;


    /**
     * @var string
     */
    protected string $answer3 = '';


    /**
     * @var string
     */
    protected string $result3 = '';


    /**
     * @var int
     */
    protected int $value3 = 0;


    /**
     * Returns the question
     *
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }


    /**
     * Sets the question
     *
     * @param string $question
     * @return void
     */
    public function setQuestion(string $question): void
    {
        $this->question = $question;
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
     * Returns the answer1
     *
     * @return string
     */
    public function getAnswer1(): string
    {
        return $this->answer1;
    }


    /**
     * Sets the answer1
     *
     * @param string $answer1
     * @return void
     */
    public function setAnswer1(string $answer1): void
    {
        $this->answer1 = $answer1;
    }


    /**
     * Returns the result1
     *
     * @return string
     */
    public function getResult1(): string
    {
        return $this->result1;
    }


    /**
     * Sets the result1
     *
     * @param string $result1
     * @return void
     */
    public function setResult1(string $result1): void
    {
        $this->result1 = $result1;
    }


    /**
     * Returns the value1
     *
     * @return int
     */
    public function getValue1(): int
    {
        return $this->value1;
    }


    /**
     * Sets the value1
     *
     * @param int $value1
     * @return void
     */
    public function setValue1(int $value1): void
    {
        $this->value1 = $value1;
    }


    /**
     * Returns the answer2
     *
     * @return string $answer2
     */
    public function getAnswer2(): string
    {
        return $this->answer2;
    }


    /**
     * Sets the answer2
     *
     * @param string $answer2
     * @return void
     */
    public function setAnswer2(string $answer2): void
    {
        $this->answer2 = $answer2;
    }


    /**
     * Returns the result2
     *
     * @return string
     */
    public function getResult2(): string
    {
        return $this->result2;
    }


    /**
     * Sets the result2
     *
     * @param string $result2
     * @return void
     */
    public function setResult2(string $result2): void
    {
        $this->result2 = $result2;
    }


    /**
     * Returns the value2
     *
     * @return int
     */
    public function getValue2(): int
    {
        return $this->value2;
    }


    /**
     * Sets the value2
     *
     * @param int $value2
     * @return void
     */
    public function setValue2(int $value2): void
    {
        $this->value2 = $value2;
    }


    /**
     * Returns the answer3
     *
     * @return string
     */
    public function getAnswer3(): string
    {
        return $this->answer3;
    }


    /**
     * Sets the answer3
     *
     * @param string $answer3
     * @return void
     */
    public function setAnswer3(string $answer3): void
    {
        $this->answer3 = $answer3;
    }


    /**
     * Returns the result3
     *
     * @return string
     */
    public function getResult3(): string
    {
        return $this->result3;
    }


    /**
     * Sets the result3
     *
     * @param string $result3
     * @return void
     */
    public function setResult3(string $result3): void
    {
        $this->result3 = $result3;
    }


    /**
     * Returns the value3
     *
     * @return int
     */
    public function getValue3(): int
    {
        return $this->value3;
    }


    /**
     * Sets the value3
     *
     * @param int $value3
     * @return void
     */
    public function setValue3(int $value3): void
    {
        $this->value3 = $value3;
    }


    /**
     * Gets the value by answer
     *
     * @param int $answer
     * @return int
     */
    public function getValueByAnswer(int $answer): int
    {
        $value = 0;

        if ($answer == 1) {
            $value = $this->value1;
        }

        if ($answer == 2) {
            $value = $this->value2;
        }

        if ($answer == 3) {
            $value = $this->value3;
        }

        return $value;

    }
}
