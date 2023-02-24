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
 * PercentCalcViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PercentCalcViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('sum', 'float', 'The current sum value.', true);
        $this->registerArgument('maxSum', 'float', 'The maximum sum value.', true);
    }


    /**
     * calculate percent
     *
     * @return float
     */
    public function render(): float
    {
        $sum = $this->arguments['sum'];
        $maxSum = $this->arguments['maxSum'];

        return round($sum / $maxSum * 100);
    }

}
