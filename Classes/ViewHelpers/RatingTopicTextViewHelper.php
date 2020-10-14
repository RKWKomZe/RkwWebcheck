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
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * RatingTopicCssViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class RatingTopicTextViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Returns the corresponding text for the percentage value
     *
     * @param \RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult
     * @return string
     */
    public function render(\RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult)
    {
        $rating = $topicResult->getTopic()->getResultA();
        if ($topicResult->getPercentage() <= 34) {
            $rating = $topicResult->getTopic()->getResultC();
        } elseif ($topicResult->getPercentage() <= 64) {
            $rating = $topicResult->getTopic()->getResultB();
        }

        return $rating;
        //===
    }

}