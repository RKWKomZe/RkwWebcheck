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
     * @var string
     */
    protected string $name = '';


    /**
     * @var string
     */
    protected string $description = '';


    /**
     * @var int
     */
    protected int $checkPid = 0;


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
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\Topic>|null
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?ObjectStorage $topics = null;


    /**
     * @var bool
     */
    protected bool $showHints = true;


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
     * Returns the name
     *
     * @return string $name
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
     * Returns the checkPid
     *
     * @return int
     */
    public function getCheckPid(): int
    {
        return $this->checkPid;
    }


    /**
     * Sets the checkPid
     *
     * @param int $checkPid
     * @return void
     */
    public function setCheckPid(int $checkPid): void
    {
        $this->checkPid = $checkPid;
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
     * @return bool
     */
    public function getShowHints(): bool
    {
        return $this->showHints;
    }


    /**
     * @param bool $showHints
     * @return void
     */
    public function setShowHints(bool $showHints): void
    {
        $this->showHints = $showHints;
    }


    /**
     * Adds a Topic
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Topic $topic
     * @return void
     */
    public function addTopic(Topic $topic): void
    {
        $this->topics->attach($topic);
    }

    /**
     * Removes a Topic
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Topic $topicToRemove The Topic to be removed
     * @return void
     */
    public function removeTopic(Topic $topicToRemove): void
    {
        $this->topics->detach($topicToRemove);
    }


    /**
     * Returns the topics
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\Topic> $topics
     */
    public function getTopics(): ObjectStorage
    {
        return $this->topics;
    }


    /**
     * Sets the topics
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWebcheck\Domain\Model\Topic> $topics
     * @return void
     */
    public function setTopics(ObjectStorage $topics): void
    {
        $this->topics = $topics;
    }
}
