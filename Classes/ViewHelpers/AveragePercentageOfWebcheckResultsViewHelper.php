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
 * AveragePercentageOfWebcheckResultsViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class AveragePercentageOfWebcheckResultsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * calculate average topic percentage
     *
     * @param mixed $averagePoints
     * @param mixed $maxPoints
     * @return integer
     */
    public function render($averagePoints, $maxPoints)
    {
        return round($averagePoints / $maxPoints * 100, 2);
        //===
    }

}