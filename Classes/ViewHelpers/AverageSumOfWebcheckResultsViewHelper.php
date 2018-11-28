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

/**
 * AverageSumOfWebcheckResultsViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class AverageSumOfWebcheckResultsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * calculate average topic value
     *
     * @param array $resultList
     * @param \RKW\RkwWebcheck\Domain\Model\Topic $topic
     * @return integer
     */
    public function render($resultList, $topic)
    {
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
        //===
    }

}