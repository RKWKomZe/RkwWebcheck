<?php

namespace RKW\RkwWebcheck\ViewHelpers;
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

use RKW\RkwWebcheck\Domain\Model\Topic;

/**
 * AverageSumOfWebcheckResultsViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class AverageSumOfWebcheckResultsViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('resultList', 'array', 'The array of results.', true);
        $this->registerArgument('topic', Topic::class, 'The current topic.', true);
    }


    /**
     * calculate average topic value
     *
     * @return float
     */
    public function render(): float
    {
        /** @var array $resultList */
        $resultList = $this->arguments['resultList'];

        /** @var \RKW\RkwWebcheck\Domain\Model\Topic $topic */
        $topic = $this->arguments['topic'];

        $topicSum = 0;
        $counter = 0;
        /** @var \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult */
        foreach ($resultList as $checkResult) {
            /** @var \RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult */
            foreach ($checkResult->getResults() as $topicResult) {

                if ($topicResult->getTopic()->getUid() == $topic->getUid()) {
                    $counter++;
                    $topicSum += $topicResult->getSum();
                }
            }
        }

        return round($topicSum / $counter, 2);
    }

}
