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

/**
 * RatingCheckCssViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class RatingCheckTextViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('checkResult', CheckResult::class, 'The checkResult-object.', true);
    }


    /**
     * Returns the corresponding text for the percentage value
     *
     * @return string
     */
    public function render(): string
    {
        /** @var \RKW\RkwWebcheck\Domain\Model\CheckResult $checkResult */
        $checkResult = $this->arguments['checkResult'];

        $rating = $checkResult->getWebcheck()->getResultA();
        if ($checkResult->getPercentage() <= 34) {
            $rating = $checkResult->getWebcheck()->getResultC();
        } elseif ($checkResult->getPercentage() <= 64) {
            $rating = $checkResult->getWebcheck()->getResultB();
        }

        return $rating;
    }

}
