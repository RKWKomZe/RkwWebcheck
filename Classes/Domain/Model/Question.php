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
     * question
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $question;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * answer1
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $answer1;

    /**
     * result1
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $result1;

    /**
     * value1
     *
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $value1 = 0;

    /**
     * answer2
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $answer2;

    /**
     * result2
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $result2;

    /**
     * value2
     *
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $value2 = 0;

    /**
     * answer3
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $answer3;

    /**
     * result3
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $result3;

    /**
     * value3
     *
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $value3 = 0;

    /**
     * Returns the question
     *
     * @return string $question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Sets the question
     *
     * @param string $question
     * @return void
     */
    public function setQuestion($question)
    {
        $this->question = $question;
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
     * Returns the answer1
     *
     * @return string $answer1
     */
    public function getAnswer1()
    {
        return $this->answer1;
    }

    /**
     * Sets the answer1
     *
     * @param string $answer1
     * @return void
     */
    public function setAnswer1($answer1)
    {
        $this->answer1 = $answer1;
    }

    /**
     * Returns the result1
     *
     * @return string $result1
     */
    public function getResult1()
    {
        return $this->result1;
    }

    /**
     * Sets the result1
     *
     * @param string $result1
     * @return void
     */
    public function setResult1($result1)
    {
        $this->result1 = $result1;
    }

    /**
     * Returns the value1
     *
     * @return int $value1
     */
    public function getValue1()
    {
        return $this->value1;
    }

    /**
     * Sets the value1
     *
     * @param int $value1
     * @return void
     */
    public function setValue1($value1)
    {
        $this->value1 = $value1;
    }

    /**
     * Returns the answer2
     *
     * @return string $answer2
     */
    public function getAnswer2()
    {
        return $this->answer2;
    }

    /**
     * Sets the answer2
     *
     * @param string $answer2
     * @return void
     */
    public function setAnswer2($answer2)
    {
        $this->answer2 = $answer2;
    }

    /**
     * Returns the result2
     *
     * @return string $result2
     */
    public function getResult2()
    {
        return $this->result2;
    }

    /**
     * Sets the result2
     *
     * @param string $result2
     * @return void
     */
    public function setResult2($result2)
    {
        $this->result2 = $result2;
    }

    /**
     * Returns the value2
     *
     * @return int $value2
     */
    public function getValue2()
    {
        return $this->value2;
    }

    /**
     * Sets the value2
     *
     * @param int $value2
     * @return void
     */
    public function setValue2($value2)
    {
        $this->value2 = $value2;
    }

    /**
     * Returns the answer3
     *
     * @return string $answer3
     */
    public function getAnswer3()
    {
        return $this->answer3;
    }

    /**
     * Sets the answer3
     *
     * @param string $answer3
     * @return void
     */
    public function setAnswer3($answer3)
    {
        $this->answer3 = $answer3;
    }

    /**
     * Returns the result3
     *
     * @return string $result3
     */
    public function getResult3()
    {
        return $this->result3;
    }

    /**
     * Sets the result3
     *
     * @param string $result3
     * @return void
     */
    public function setResult3($result3)
    {
        $this->result3 = $result3;
    }

    /**
     * Returns the value3
     *
     * @return int $value3
     */
    public function getValue3()
    {
        return $this->value3;
    }

    /**
     * Sets the value3
     *
     * @param int $value3
     * @return void
     */
    public function setValue3($value3)
    {
        $this->value3 = $value3;
    }


    /**
     * Gets the value by answer
     *
     * @param $answer
     * @return int|null
     */
    public function getValueByAnswer($answer)
    {
        $value = null;

        if ($answer == '1') {
            $value = $this->value1;
        }

        if ($answer == '2') {
            $value = $this->value2;
        }

        if ($answer == '3') {
            $value = $this->value3;
        }

        return $value;

    }
}
