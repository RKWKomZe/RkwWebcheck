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

use RKW\RkwWebcheck\Domain\Model\CheckResult;
use RKW\RkwWebcheck\Domain\Model\TopicResult;
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
class RatingTopicTextViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{



    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('checkResult', TopicResult::class, 'The topicResult-object.', true);
    }


    /**
     * Returns the corresponding text for the percentage value
     *
     * @return string
     */
    public function render(): string
    {
        /** @var \RKW\RkwWebcheck\Domain\Model\TopicResult $topicResult */
        $topicResult = $this->arguments['topicResult'];

        $rating = $topicResult->getTopic()->getResultA();
        if ($topicResult->getPercentage() <= 34) {
            $rating = $topicResult->getTopic()->getResultC();
        } elseif ($topicResult->getPercentage() <= 64) {
            $rating = $topicResult->getTopic()->getResultB();
        }

        return $rating;
    }

}
