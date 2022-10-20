<?php

namespace RKW\RkwWebcheck\Domain\Model;

/***
 * /*
 * This file is part of the TYPO3 CMS project.
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class Webcheck
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Philipp Grigoleit <p.grigoleit@agentur-fahrenheit.de>
 * @author Salih Özdemir <s.oezdemir@agentur-fahrenheit.de>
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Webcheck extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * name
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $name;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * checkPid
     *
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $checkPid = 0;

    /**
     * resultA
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $resultA;

    /**
     * resultB
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $resultB;

    /**
     * resultC
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $resultC;

    /**
     * topics
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\Topic>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $topics;

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
     * Returns the checkPid
     *
     * @return int $checkPid
     */
    public function getCheckPid()
    {
        return $this->checkPid;
    }

    /**
     * Sets the checkPid
     *
     * @param int $checkPid
     * @return void
     */
    public function setCheckPid($checkPid)
    {
        $this->checkPid = $checkPid;
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
     * showHints
     *
     * @var boolean
     */
    protected $showHints = true;

    /**
     * @return boolean
     */
    public function getShowHints()
    {
        return $this->showHints;
    }

    /**
     * @param boolean $showHints
     */
    public function setShowHints($showHints)
    {
        $this->showHints = $showHints;
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
        $this->topics = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a Topic
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Topic $topic
     * @return void
     */
    public function addTopic(Topic $topic)
    {
        $this->topics->attach($topic);
    }

    /**
     * Removes a Topic
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Topic $topicToRemove The Topic to be removed
     * @return void
     */
    public function removeTopic(Topic $topicToRemove)
    {
        $this->topics->detach($topicToRemove);
    }

    /**
     * Returns the topics
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\Topic> $topics
     */
    public function getTopics()
    {
        return $this->topics;
    }

    /**
     * Sets the topics
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\Topic> $topics
     * @return void
     */
    public function setTopics($topics)
    {
        $this->topics = $topics;
    }
}
